<script>
import selectedTeam from './components/selectedTeam.vue';

export default {
  props: [],
  components: {
    selectedTeam
  },
  data() {
   return{
    Teams: [],
      loading: false,
      error: null
   }
  },
  mounted() {
    this.fetchTeams();
  },
  methods: {
    async fetchTeams() {
      this.loading = true;
      this.error = null;
      
      try {
        const response = await fetch('http://localhost/football/back/TeamsController.php/?method=getTeams');
        
        const data = await response.json();
        this.Teams = data;
        
      } catch (error) {
        console.error('Error fetching teams:', error);
        this.error = error.message;
      } finally {
        this.loading = false;
      }
    }
  }
}
</script>

<template>
    <div class="TeamsList">
        <selectedTeam  v-for="emp in Teams"
      :key="emp.id"
      :id="emp.id"
      :name="emp.name"
      :color="emp.color"
      :common_rate="emp.common_rate" />
    </div>
</template>


<style>
.TeamsList {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 15px;
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
}

body {
  background-color: green;
  min-height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  margin: 0;
  padding: 20px;
  font-family: Arial, Helvetica, sans-serif
}

/* Адаптивные колонки */
@media (max-width: 768px) {
  .TeamsList {
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
  }
}

@media (max-width: 480px) {
  .TeamsList {
    grid-template-columns: 1fr;
  }
}
</style>