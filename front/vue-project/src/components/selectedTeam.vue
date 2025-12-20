<script>
export default {

  props: ["id","name","color","common_rate"],
  methods:{
    textColor() {
      const hex = this.color.replace('#', '');
      const r = parseInt(hex.substr(0, 2), 16);
      const g = parseInt(hex.substr(2, 2), 16);
      const b = parseInt(hex.substr(4, 2), 16);
      const brightness = (r * 299 + g * 587 + b * 114) / 1000;
      return brightness > 128 ? '#000000' : '#FFFFFF';
    }
  },
  data() {
    return {
        cssVars: {
        '--team-color': this.color,
        '--text-color':this.textColor(),
      }
    }
  },
}
</script>
<template>
  <a class="line" :style="cssVars" href="{{ '/Team' + id }}">
      <span>{{ name }}</span>
      <span>|</span>
      <span>{{ common_rate }}</span>
  </a>
</template>

<style>

    .line{
      display: block;
        background-color: var(--team-color);
        height: 40px;
        margin-bottom: 5%;
        border-radius: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        color: var(--text-color);
    }
    .line:hover {
  filter: brightness(0.9); /* Затемнение */
  transform: scale(1.02); /* Легкое увеличение */
  border-color: rgba(255, 255, 255, 0.3); /* Белая рамка */
}

</style>


