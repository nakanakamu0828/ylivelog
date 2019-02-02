<template>
  <div class="min-h-screen flex flex-col font-sans">
    <app-header />
    <Loading v-show="$store.getters.isLoading" />
    <div class="flex-grow relative">
      <slot/>
    </div>
    <app-footer />
  </div>
</template>


<script>
import AppHeader from '~/components/organisms/app-header'
import AppFooter from '~/components/organisms/app-footer'
import Loading from '~/components/atoms/loading'

export default {
  components: { AppHeader, AppFooter, Loading },
  data: () => ({
  })
}
</script>