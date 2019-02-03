<template>
  <div class="relative z-10">
      <img
        class="w-10 h-10 rounded-full hover:opacity-75"
        :src="user.profile_image_url"
        :alt="user.name"
        @click="drawer = !drawer"
      >
      <div
        class="absolute w-48 pin-t pin-r mt-12 bg-white shadow rounded border overflow-hidden"
        :class="{ invisible: !drawer }"
      >
        <a
          href="#"
          class="no-underline block px-4 py-3 border-b text-grey-darkest bg-white hover:text-white hover:bg-grey whitespace-no-wrap"
          @click="logout"
        >
          Logout
        </a>
      </div>
  </div>
</template>


<script>
import eventListener from '~/mixins/eventListener'
export default {
  mixins:[ eventListener ],
  props: {
    user: {
      type: Object,
      required: true,
    },
  },
  components: {},
  data: () => ({
    drawer: false
  }),
  // created:function(){
  //   this.listen(window, 'click', function(e){
  //     if (!this.$el.contains(e.target)){
  //       this.drawer = false
  //     }
  //   }.bind(this));
  // },
  methods: {
    logout(event) {
        this.$emit('logout')
    }
  }
}
</script>