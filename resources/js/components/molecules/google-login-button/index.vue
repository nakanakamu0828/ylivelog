<template>
  <a
    class="btn bg-red hover:bg-red-dark text-white font-bold py-4 px-12 rounded-full"
    @click="click"
  >
    Googleログイン
  </a>
</template>

<script>
export default {
  methods: {
    click(event) {
      this.$emit('click', event)
    }
  }
}
</script>