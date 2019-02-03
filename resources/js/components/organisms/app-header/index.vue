<template>
  <header class="flex justify-between bg-white border-b border-grey-lighter py-5 px-2 lg:px-5">
    <div class="text-center">
    </div>
    <div class="text-center">
      <router-link
        to="/"
        class="font-mono text-xl"
        v-text="app_name"
      >
      </router-link>
      <p class="mt-2 text-xs text-grey-darken" v-text="description"></p>
    </div>
    <div>
      <menu-dropdown
        v-if="isLoggined"
        :user="user"
        v-on:logout="logout"
      />
    </div>
  </header>
</template>


<script>
import MenuDropdown from '~/components/molecules/menu-dropdown'

export default {
  components: { MenuDropdown },
  data: () => ({
    app_name: process.env.MIX_APP_NAME,
    description: process.env.MIX_APP_DESCRIPTION
  }),
  methods: {
    async logout() {
      await this.$store.dispatch('auth/logout', this.form)
      this.$router.push('/')
    },
  },
  computed: {
    isLoggined () {
      return this.$store.getters['auth/isLoggined']
    },
    user () {
      return this.$store.getters['auth/user']
    }
  }
}
</script>