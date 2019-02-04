<template>
  <router-link
    :to="`/archive/${video.id}`"
    class="w-full flex mb-4"
    :disabled="!video.id"
  >
    <div
      class="min-h-24 lg:h-32 w-32 lg:w-48 flex-none bg-cover rounded-t-none rounded-l text-center overflow-hidden"
      :style="{ 'background-image': 'url(' + video.image_url + ')' }"
      :title="video.title"
    >
    </div>
    <div class="border-r border-b border-l border-grey-light border-l-0 border-t border-grey-light bg-white rounded-b rounded-b-none rounded-r p-2 md:p-4 flex flex-col justify-between w-full">
      <div class="text-black font-bold text-lg mb-4" v-text="video.title"></div>
    </div>
  </router-link>
</template>


<script>
export default {
  props: {
    video: {
      type: Object,
      required: true,
    },
  },
  components: {},
  data: () => ({
  }),
  computed: {
  },
  methods: {
  }
}
</script>