<template>
  <div class="relative float-right">
      <svg
        class="h-6 w-6"
        version="1.1" 
        viewBox="0 0 36 36"
        preserveAspectRatio="xMidYMid meet"
        xmlns="http://www.w3.org/2000/svg"
        xmlns:xlink="http://www.w3.org/1999/xlink"
        @click="drawer = !drawer"
      >
          <title>ellipsis-vertical-line</title>
          <circle cx="18" cy="4.9" r="2.9" class="clr-i-outline clr-i-outline-path-1"></circle><circle cx="18" cy="18" r="2.9" class="clr-i-outline clr-i-outline-path-2"></circle><circle cx="18" cy="31.1" r="2.9" class="clr-i-outline clr-i-outline-path-3"></circle>
          <rect x="0" y="0" width="36" height="36" fill-opacity="0"/>
      </svg>
      <div
        class="absolute w-48 pin-t pin-r mt-12 bg-white shadow rounded border overflow-hidden"
        :class="{ invisible: !drawer }"
      >
        <router-link
          to="/login"
          class="no-underline block px-4 py-3 border-b text-grey-darkest bg-white hover:text-white hover:bg-grey whitespace-no-wrap"
          v-if="!isLoggined"
        >
          Login
        </router-link>
        <router-link
          to="/register"
          class="no-underline block px-4 py-3 border-b text-grey-darkest bg-white hover:text-white hover:bg-grey whitespace-no-wrap"
          v-if="!isLoggined"
        >
          Register
        </router-link>
        <a
          href="#"
          class="no-underline block px-4 py-3 border-b text-grey-darkest bg-white hover:text-white hover:bg-grey whitespace-no-wrap"
          v-if="isLoggined"
          @click="logout"
        >
          Logout
        </a>
      </div>
  </div>
</template>


<script>
export default {
  components: {},
  data: () => ({
    drawer: false
  }),
  computed: {
    isLoggined () {
      return this.$store.getters['auth/isLoggined']
    },
    user () {
      return this.$store.getters['auth/user']
    }
  },
  methods: {
    logout(event) {
        this.$emit('logout')
    }
  }
}
</script>