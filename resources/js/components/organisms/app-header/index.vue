<template>
  <header class="flex flex-no-wrap bg-white border-b border-grey-lighter p-5">
    <div class="w-1/6">
    </div>
    <div class="w-5/6 text-center">
      <router-link
        to="/"
        class="font-mono text-xl"
        v-text="app_name"
      >
      </router-link>
      <p class="mt-2 text-xs text-grey-darken" v-text="description"></p>
    </div>
    <div class="w-1/6">
    </div>
  </header>
</template>


<script>
export default {
  components: { },
  data: () => ({
    app_name: process.env.MIX_APP_NAME,
    description: process.env.MIX_APP_DESCRIPTION
  }),
  methods: {
  }
}
</script>