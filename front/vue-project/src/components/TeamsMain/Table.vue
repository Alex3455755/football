<script>
export default {
  name: 'Table',
  props: {
    teamsList: {
      type: Array,
      default: () => []
    }
  },
  methods: {
  textColor(bgColor) {
    const hex = bgColor.replace('#', '');
    const r = parseInt(hex.substr(0, 2), 16);
    const g = parseInt(hex.substr(2, 2), 16);
    const b = parseInt(hex.substr(4, 2), 16);
    const brightness = (r * 299 + g * 587 + b * 114) / 1000;
    return brightness > 128 ? '#000000' : '#FFFFFF';
  }
},
  computed: {
    sortedTeams() {
      return [...this.teamsList].sort((a, b) => b.count_points - a.count_points);
    }
  }
}
</script>

<template>
  <div class="display">
    <table class="teams-table">
      <thead>
        <tr>
          <th>Позиция</th>
          <th>Команда</th>
          <th>Рейтинг</th>
          <th>Очки</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(team, index) in sortedTeams" :key="team.id">
          <td
  class="position-cell"
  :style="{
    backgroundColor: team.color,
    color: textColor(team.color)
  }"
>
  {{ index + 1 }}
</td>

          <td>{{ team.name }}</td>
          <td>{{ team.common_rate }}</td>
          <td>{{ team.count_points }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<style scoped>
.display {
  padding: 16px;
}

.teams-table {
  width: 100%;
  border-collapse: collapse;
  background-color: #fff;
}

.teams-table th,
.teams-table td {
  border: 1px solid #ccc;
  padding: 8px 10px;
  text-align: left;
}

.teams-table thead {
  background-color: #f3f3f3;
}

.position-cell {
  color: #000;
  font-weight: 600;
}
</style>
