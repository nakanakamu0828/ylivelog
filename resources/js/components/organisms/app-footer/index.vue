<template>
  <footer class="bg-grey-darkest text-white p-6">
    <div class="container mx-auto px-4">
      <div
        class="flex flex-wrap"
        v-if="isLoggined"
      >
        <div class="w-full md:w-1/5 mb-4">
        </div>
        <div class="w-full md:w-3/5 mb-4 text-xs sm:text-sm text-center">
          <router-link
            to="/"
            class="text-white hover:text-grey-dark no-underline"
          >
            Home
          </router-link>
          &nbsp;/&nbsp;
          <router-link
            to="/archives"
            class="text-white hover:text-grey-dark no-underline"
          >
            動画アーカイブ
          </router-link>
        </div>
        <div class="w-full md:w-1/5 mb-4 flex justify-center">
        </div>
      </div>
      <div class="flex">
        <div class="w-full text-center text-xs">
          Copyright © 2018 @nnn All Rights Reserved.
        </div>
      </div>
    </div>
  </footer>
</template>


<script>
export default {
  components: {},
  data: () => ({
  }),
  computed: {
    isLoggined () {
      return this.$store.getters['auth/isLoggined']
    }
  }
}
</script>