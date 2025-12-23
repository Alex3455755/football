<script>
import Stroke from './components/Stroke.vue';
import MainTeamBlock from './components/MainTeamBlock.vue';

export default {
    name: 'Team',
  props: {
    id: {
      type: [String, Number],
      required: true
    }
},components: {
    Stroke,
    MainTeamBlock,
  },
  mounted() {
    this.fetchTeam();
    this.fetchPlayersByTeam();
  }, methods: {
    async fetchTeam() {
      this.loading = true;
      this.error = null;
      
      try {
        const response = await fetch(`http://localhost/football/back/TeamsController.php/?method=getTeams`);
        
        const data = await response.json();
        data.forEach(elem => {
          if(elem.id == this.id){
            this.team = elem;
          }
        });
        this.teamsList = data;
        
      } catch (error) {
        console.error('Error fetching teams:', error);
        this.error = error.message;
      } finally {
        this.loading = false;
      }
    },
    handler(){
      this.fetchTeam();
    },
    async fetchPlayersByTeam(){
        this.loading = true;
      this.error = null;
      
      try {
        const response = await fetch(`http://localhost/football/back/playersController.php/?method=getPlayersByTeam&&id=${this.id}`);
        
        const data = await response.json();
        this.players = data;
        
      } catch (error) {
        console.error('Error fetching teams:', error);
        this.error = error.message;
      } finally {
        this.loading = false;
      }
    },
    textColor() {
      const hex = this.team.color.replace('#', '');
      const r = parseInt(hex.substr(0, 2), 16);
      const g = parseInt(hex.substr(2, 2), 16);
      const b = parseInt(hex.substr(4, 2), 16);
      const brightness = (r * 299 + g * 587 + b * 114) / 1000;
      return brightness > 128 ? '#000000' : '#FFFFFF';
    }
  },
  data() {
    return {
        players: [],
        team: {
            id: 0,color: '',name: '',common_rate: 0
        },
        teamsList: [],
         cssVars: {
        '--team-color': '#CCCCCC'
      }
    }
  },
}
</script>

<template>
    <header :style="{ backgroundColor: team?.color || '#CCCCCC' ,color: this.textColor()}">
        <h2>{{ team.name }}</h2>
        <p>{{ team.common_rate }}</p>
    </header>
    <main>
    <MainTeamBlock :id = "id" :squad = "players"
    :team = "team" :teamsList ="teamsList" :color="team.color"
    :fetchTeams = "handler"/>
    </main>
</template>


<style>
    *{
        margin: 0;
        padding: 0;
    }
    body{
        display: block;
    }
</style>
