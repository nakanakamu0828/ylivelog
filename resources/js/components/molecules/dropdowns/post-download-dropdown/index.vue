<template>
  <div class="relative z-10 mb-5">
    <div
      class="flex items-center hover:opacity-75"
      @click="drawer = !drawer"
    >
      <svg class="h-5 w-5 mr-1 text-dark" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 50 50" version="1.1"><g id="surface1"><path style=" " d="M 20 8 C 13.539063 8 8.367188 13.109375 8.09375 19.5 C 3.417969 20.777344 0 24.996094 0 30 C 0 36.046875 4.953125 41 11 41 L 41 41 C 45.945313 41 50 36.945313 50 32 C 50 28.101563 47.402344 24.792969 43.90625 23.625 C 43.695313 17.761719 38.910156 13 33 13 C 31.960938 13 30.992188 13.257813 30.03125 13.53125 C 27.882813 10.261719 24.21875 8 20 8 Z M 20 10 C 23.726563 10 26.992188 12.09375 28.71875 15.09375 L 29.15625 15.8125 L 29.9375 15.53125 C 30.9375 15.167969 31.910156 15 33 15 C 37.953125 15 42 19.046875 42 24 L 42 25.09375 L 42.78125 25.28125 C 45.714844 25.972656 48 28.769531 48 32 C 48 35.855469 44.855469 39 41 39 L 11 39 C 6.046875 39 2 34.953125 2 30 C 2 25.671875 5.058594 21.996094 9.1875 21.1875 L 10 21.03125 L 10 20 C 10 14.433594 14.433594 10 20 10 Z M 24 20 L 24 31.5625 L 19.71875 27.28125 L 18.28125 28.71875 L 24.28125 34.71875 L 25 35.40625 L 25.71875 34.71875 L 31.71875 28.71875 L 30.28125 27.28125 L 26 31.5625 L 26 20 Z "/></g></svg>
      <span class="text-dark text-sm">CSVダウンロード</span>
    </div>
    <div
      class="absolute w-32 pin-t pin-r mt-6 bg-white shadow rounded border overflow-hidden"
      :class="{ 'invisible': !drawer }"
    >
      <a
        :href="`/video/${video.id}/user/download`"
        class="no-underline block px-4 py-3 border-b text-grey-darkest bg-white hover:text-white hover:bg-grey whitespace-no-wrap"
        download=""
      >
        ユーザー情報
      </a>
      <a
        :href="`/video/${video.id}/chat/download`"
        class="no-underline block px-4 py-3 border-b text-grey-darkest bg-white hover:text-white hover:bg-grey whitespace-no-wrap"
        download=""
      >
        チャット情報
      </a>
    </div>
  </div>
</template>


<script>
import eventListener from '~/mixins/eventListener'
export default {
  mixins:[ eventListener ],
  props: {
    video: {
      type: Object,
      required: true,
    },
  },
  components: {},
  data: () => ({
    drawer: false
  }),
  created:function(){
    this.listen(window, 'click', function(e){
      if (!this.$el.contains(e.target)){
        this.drawer = false
      }
    }.bind(this));
  },
  methods: {
  }
}
</script>