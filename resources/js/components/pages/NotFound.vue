<template>
  <app-layout>

    <div class="flex flex-row justify-center">
      <div class="w-full max-w-xs text-center">
        <h1 class="mt-20 mb-4" v-text="title"></h1>
        <p class="text-grey text-sm" v-text="description"></p>
      </div>
    </div>
    
  </app-layout>
</template>

<script>
import AppLayout from '~/components/templates/app-layout'

export default {
  components: { AppLayout },
  head: {
    title: function () {
      return {
        inner: this.title
      }
    },
    meta:function () {
      return [
        { id: 'description', name: 'description', content: this.description },
      ]
    }
  },
  data: () => ({
    title: 'Page not found.',
    description: 'お探しのページは削除されたか存在しません。'
  }),
}
</script>