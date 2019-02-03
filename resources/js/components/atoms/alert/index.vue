<template>
    <div
        v-if="message"
        class="absolute w-full z-20"
        :class="{ 'alert-success': 'success' === type, 'alert-info': 'info' === type, 'alert-error': 'error' === type }"
        role="alert">
        <div class="flex relative">
            <div class="py-1">
                <svg class="fill-current h-6 w-6 text-icon mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg>
            </div>
            <div>
                <p class="font-bold" v-text="message.title"></p>
                <p class="text-sm" v-text="message.description"></p>
            </div>
            <span
                class="absolute pin-t pin-r py-2"
                @click="close"
            >
                <svg class="fill-current h-6 w-6 text-dark" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
            </span>
        </div>
    </div>
</template>

<script>
export default {
  props: {
    type: {
      type: String,
      default: 'info'
    },
    message: {
      type: Object,
      required: false,
      useDefaultForNull: true
    }
  },
  methods: {
    close(event) {
      this.$emit('close', event)
    }
  }
}
</script>

<style scoped>
.alert-success {
  @apply bg-teal-lightest border-t-4 border-teal rounded-b text-teal-darkest px-4 py-3 shadow-md;
}
.alert-success .text-icon {
  @apply text-teal;
}
.alert-info {
  @apply bg-teal-lightest border-t-4 border-blue rounded-b text-blue-darkest px-4 py-3 shadow-md;
}
.alert-info .text-icon {
  @apply text-blue;
}
.alert-error {
  @apply bg-red-lightest border-t-4 border-red rounded-b text-red-darkest px-4 py-3 shadow-md;
}
.alert-error .text-icon {
  @apply text-red;
}
</style>