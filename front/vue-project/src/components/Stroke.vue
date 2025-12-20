<script>
export default {

  props: ["name","number","rate"],
   mounted() {
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


