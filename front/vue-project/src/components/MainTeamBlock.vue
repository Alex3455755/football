<script>


export default {
    name: 'MainTeamBlock',
  props: {
    id: 0,
    squad: {
            type: Array,
            default: () => []
        },
        team: {
            type: Object,
            default: () => ({}),
        teamList: {
            type: Array,
            default: () => []
        },
},
  data() {
    return {
        teamList: [],
        squad: [],
        team: {
            id: 0,color: '',name: '',common_rate: 0
        },
         cssVars: {
        '--team-color': '#CCCCCC'
      }
    }
  },
}
}
</script>

<template>
    <div class="display">
        <aside>
            <nav class="navigation">
                <button>Главная</button>
                <button>Состав</button>
                <button id="nextGame">Следующий Матч</button>
            </nav>
        </aside>
        <article>
                    <p>{{ id }}</p>
        <p>{{ team }}</p>
        <p>{{ squad }}</p>
        </article>
    </div>
</template>


<style>
    .display{
        display: flex;
        height: 80vh;
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
        height: 200px;
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
