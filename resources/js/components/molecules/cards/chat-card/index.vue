<template>
  <div class="flex items-center p-2">
    <img :src="post.autor_profile_image_url" :alt="post.autor_display_name" class="w-10 h-10 rounded-full mr-2">
    <div class="w-full text-sm p-1">
      <div class="flex justify-between mb-1">
        <p class="text-black leading-none" v-text="post.autor_display_name"></p>
        <p class="text-grey-dark" v-text="post.published_at"></p>
      </div>
      <p class="text-grey-darker font-bold mb-2" v-text="post.message"></p>
    </div>
  </div>
</template>


<script>
export default {
  props: {
    post: {
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