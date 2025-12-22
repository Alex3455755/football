<script>
import Table from './TeamsMain/Table.vue';
import Squad from './TeamsMain/Squad.vue';
import GameBoard from './TeamsMain/GameBoard.vue';

export default {
  name: 'MainTeamBlock',
  components: {
    Table,
    Squad,
    GameBoard,
  },
  props: {
    id: Number,
    squad: {
      type: Array,
      default: () => []
    },
    team: {
      type: Object,
      default: () => ({})
    },
    teamsList: {
      type: Array,
      default: () => []
    },
    color: {
      type: String,
      default: ''
    }
  },
  data() {
    return {
      cssVars: {
        '--team-color': '#CCCCCC'
      },
      currentComponent: 'Table',
      startSquad: [],
      calendar: [],
      tour: 0,
    }
  },
  watch: {
    teamsList: {
      immediate: true,
      deep: true,
      handler(newVal) {
        if (!Array.isArray(newVal) || newVal.length === 0) {
          this.calendar = [];
          return;
        }
        this.calendar = this.shuffle([...newVal]);
      }
    }
  },
  methods: {
    changeComponent(e) {
      const text = e.target.textContent;
      if (text === 'Главная') {
        this.currentComponent = 'Table';
      } else if (text === 'Состав') {
        this.currentComponent = 'Squad';
      }else if (text === 'Следующий Матч') {
        this.currentComponent = 'GameBoard';
      }
    },
    changeStartSquad(arr) {
      this.startSquad = arr;
    },
    closeModal(){
        this.currentComponent = "Table";
    },
    shuffle(array) {
    const filtered = array.filter(team => team.id !== this.team.id);


    let currentIndex = filtered.length;
    while (currentIndex !== 0) {
    const randomIndex = Math.floor(Math.random() * currentIndex);
    currentIndex--;

    [filtered[currentIndex], filtered[randomIndex]] = [
      filtered[randomIndex],
      filtered[currentIndex]
    ];
  }
    return filtered;
    },
    callBackTour(){
        this.tour++;
    }

  }
}
</script>

<template>
  <div class="display">
    <aside>
      <nav class="navigation">
        <button @click="changeComponent($event)">Главная</button>
        <button @click="changeComponent($event)">Состав</button>
        <button @click="changeComponent($event)" id="nextGame">Следующий Матч</button>
      </nav>
    </aside>
    <article>
      <component
        :is="currentComponent"
        :teamsList="teamsList"
        :squad="squad"
        :color="color"
        :callbackStartSquad="changeStartSquad"
        :startingXI="startSquad"
        :MyTeam="team"
        :OpponentTeam="calendar[tour]"
        :callbackClose="closeModal"
        :callbackTour="callBackTour"
      />
      <ul>
        <li v-for="team in calendar" :key="team.id">
          {{ team.name }}
        </li>
      </ul>
    </article>
  </div>
</template>

<style>
    .display{
        display: flex;
        background-color: darkgrey;
    }
    .navigation{
        padding-top: 20px;
        width: 15vw;
        display: flex;
        flex-direction: column;
        justify-content: space-around;
        background-color: rgb(63, 59, 59);
        align-items: center;
        height: 300px;
    }
    .navigation > button{
        background-color: lightgrey;
        border: 1px solid #000;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 80%;
        height: 30px;
        border-radius: 2px;
        font-size: 18px;
    }
    .navigation > *:hover{
        background-color: rgb(155, 146, 146);
    }
    #nextGame:hover{
        background-color: rgb(220, 97, 97);
    }
    article{
        width: 100%;
    }
</style>
