<template>
    <div class="bg-blue-lightest border-t border-b border-blue text-blue-dark px-4 py-3" role="alert">
        <p class="font-bold mb-1" v-text="title"></p>
        <p class="text-xs" v-text="message"></p>
    </div>
</template>

<script>
export default {
  props: {
    title: {
      type: String,
      required: false,
    },
    message: {
      type: Object,
      required: false,
    }
  },
  methods: {
  }
}
</script>

<style scoped>
</style>