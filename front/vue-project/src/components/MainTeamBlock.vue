<script>
    import Table from './TeamsMain/Table.vue';
    import Squad from './TeamsMain/Squad.vue';
export default {
    name: 'MainTeamBlock',
    components: {
        Table,
        Squad,
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
        color: '',
    },methods: {
  changeComponent(e) {
    if (e.target.textContent === 'Главная') {
      this.currentComponent = 'Table';
    }if(e.target.textContent === 'Состав'){
        this.currentComponent = 'Squad';
    }
  }
}
,
    data() {
        return {
            cssVars: {
                '--team-color': '#CCCCCC'
            },
            currentComponent: 'Table'
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
            />

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
