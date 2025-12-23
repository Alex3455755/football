<script>
export default {
  name: 'GameBoard',
  props: {
    teamsList: {
      type: Array,
      default: () => []
    },
    MyTeam: {
      type: Object,
      default: () => ({})
    },
    OpponentTeam: {
      type: Object,
      default: () => ({})
    },
    callbackTour: {
      type: Function,
      default: null
    },
    startingXI: {
      type: Array,
      default: () => []
    },
    callbackClose: {
      type: Function,
      default: null
    },
  },
  data() {
    return {
      myScore: 0,
      opScore: 0
    }
  },
  computed: {
    cssVars() {
      const myColor = this.MyTeam.color || '#cccccc';
      const oppColor = this.OpponentTeam.color || '#cccccc';

      return {
        '--Myteam-color': myColor,
        '--Mytext-color': this.textColor(myColor),
        '--Opponentteam-color': oppColor,
        '--Opponenttext-color': this.textColor(oppColor)
      };
    }
  },
  methods: {
    textColor(bgColor) {
      const hex = (bgColor || '#ffffff').replace('#', '');
      const r = parseInt(hex.substr(0, 2), 16);
      const g = parseInt(hex.substr(2, 2), 16);
      const b = parseInt(hex.substr(4, 2), 16);
      const brightness = (r * 299 + g * 587 + b * 114) / 1000;
      return brightness > 128 ? '#000000' : '#FFFFFF';
    },
    startGame() {
      let sr = 0;
      this.startingXI.forEach(elem => {
        sr += elem.rate;
      });
      sr /=5;
      sr -= this.OpponentTeam.common_rate;
      if(Math.random() < 0.5){
        this.randomGoal(sr);
        this.randomGoal(sr);
        this.randomGoal(sr);       
      }else if(Math.random() < 0.4){
                this.randomGoal(sr);
        this.randomGoal(sr);
        this.randomGoal(sr);
        this.randomGoal(sr);
      }else if(Math.random() < 0.3){
        this.randomGoal(sr);
        this.randomGoal(sr);
        this.randomGoal(sr);
        this.randomGoal(sr);
        this.randomGoal(sr);
      }else if(Math.random() < 0.1){
        for (let i=0;i++;i< parseInt(Math.random()*10)){
            this.randomGoal(sr);
        }
      }else{
        this.randomGoal(sr);
        this.randomGoal(sr);
      }
      document.getElementById('play').style.display = 'none';
        document.getElementById('close').style.display = 'block';


    },
   async fetchPoints(idTeam, countPoints) {
  this.loading = true;
  this.error = null;
  
  try {
    const response = await fetch('http://localhost/football/back/TeamsController.php/?method=setPoints', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        idTeam: idTeam,
        countPoints: countPoints
      })
    });
    
    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }
    
    const data = await response.json();
    
  } catch (error) {
    console.error('Error fetching points:', error);
    this.error = error.message;
  } finally {
    this.loading = false;
  }
}
,
    async closeModal(){
        const list = this.teamsList.filter(team => team.id !== this.MyTeam.id && team.id !== this.OpponentTeam.id);
        for(let i = 0; i < list.length; i += 2){
                if(Math.random() < 0.5){
                  await this.fetchPoints(list[i].id,3)
                }else if(Math.random() < 0.5){
                  await this.fetchPoints(list[i+1].id,3)
                }else{
                      await Promise.all([
                      this.fetchPoints(list[i].id, 1),
                      this.fetchPoints(list[i+1].id, 1)
                    ]);
                }
        }
        if(this.myScore > this.opScore){
    await this.fetchPoints(this.MyTeam.id, 3);
  } else if(this.opScore > this.myScore){
    await this.fetchPoints(this.OpponentTeam.id, 3);
  } else {
    await Promise.all([
      this.fetchPoints(this.MyTeam.id, 1),
      this.fetchPoints(this.OpponentTeam.id, 1)
    ]);
  }
        this.callbackClose();
        this.callbackTour();
    },
    randomGoal(sr) {
  let myChance = 0.5;
  
  if (sr > 0) {
    myChance += Math.min(sr * 0.015, 0.3);
  } else {
    myChance += Math.max(sr * 0.015, -0.3);
  }
  
  if (Math.random() < myChance) {
    this.myScore++;
  } else {
    this.opScore++;
  }
}
  }
}
</script>


<template>
  <div class="backdrop" :style="cssVars">
    <div class="modal">
      <div class="board">
        <div>
          <p>{{ MyTeam.name }}</p>
          <div id="left"></div>
          <span class="score">{{ myScore }}</span>
        </div>
        <span class="score">:</span>
        <div>
          <p>{{ OpponentTeam.name }}</p>
          <div id="right"></div>
          <span class="score">{{ opScore }}</span>
        </div>
      </div>
      <button id="play" @click="startGame">Играть</button>
      <button id="close" @click="closeModal">Завершить матч</button>
    </div>
  </div>
</template>

<style scoped>
    #close{
        display: none;
    }
.board{
  display: flex;
  width: 100%;
  padding-top: 10vh;
  font-size: 30px;
}
#left,#right{
  width: 80px;
  height: 80px;
  border-radius: 50%;
  margin-top: 10px;
}
#left{
  background-color: var(--Myteam-color);
}
#right{
  background-color: var(--Opponentteam-color);
}
.board >div{
  width: 50%;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
}
.score{
  font-size: 70px;
  margin-top: 30px;
}
.backdrop {
  position: fixed;
  inset: 0;
  background-color: rgba(0, 0, 0, 0.6);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 999;
}
.modal button{
    width: 10vw;
    height: 40px;
    border-radius: 5px;
    background-color: rgb(220, 97, 97);
    border: none;
}
.modal button:hover{
    background-color: rgb(150, 58, 58);
}

.modal {
  width: 60vw;
  height: 60vh;
  background-color: rgb(68, 161, 68);
  border-radius: 10px;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
  padding: 20px;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
}
</style>
