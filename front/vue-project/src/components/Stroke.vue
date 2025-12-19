<script>
export default {

  props: ["name","number","rate"],
   mounted() {
    // Проверьте, приходят ли props
    console.log('Employee mounted with:', this.name, this.number, this.rate)
  },
  data() {
    return {
    }
  }
}
</script>
<template>
  <div class="stoke">
      <span>{{ name }}</span>
      <span>|</span>
      <span>{{ number }}</span>
      <span>|</span>
      <span>{{ rate }}</span>
  </div>
</template>


