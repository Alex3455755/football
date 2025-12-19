<script>
import Stroke from './components/Stroke.vue';

export default {
  props: [],
  components: {
    Stroke
  },
  data() {
    return {
      players: [], // Начально пустой массив
      loading: false,
      error: null
    }
  },
  mounted() {
    this.fetchPlayers();
  },
  methods: {
    async fetchPlayers() {
      this.loading = true;
      this.error = null;
      
      try {
        const response = await fetch('http://localhost/football/back/players.php');
        
        const data = await response.json();
        this.players = data;
        
      } catch (error) {
        console.error('Error fetching players:', error);
        this.error = error.message;
        
        // Запасной вариант: используем начальные данные если запрос не удался
        this.players = [
          {
            id: 1,
            name: 'Alex',
            number: 10,
            rate: 88,
          },
          {
            id: 2,
            name: 'Messi',
            number: 20,
            rate: 99,
          },
          {
            id: 3,
            name: 'Ronaldo',
            number: 7,
            rate: 95
          }
        ];
      } finally {
        this.loading = false;
      }
    }
  }
}
</script>

<template>
  <div>
    <div v-if="loading" class="loading">
      Загрузка данных...
    </div>
    <div v-if="error" class="error">
      Ошибка: {{ error }}
    </div>
    <Stroke 
      v-for="emp in players"
      :key="emp.id"
      :name="emp.name"
      :number="emp.number"
      :rate="emp.rate"
    />

    <button 
      v-if="!loading" 
      @click="fetchPlayers" 
      class="reload-btn"
    >
      Обновить данные
    </button>
  </div>
</template>
