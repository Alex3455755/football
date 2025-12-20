import { createApp } from 'vue'
import { createRouter, createWebHistory } from 'vue-router'
import App from './App.vue'
import Main from './Main.vue'
import SelectTeam from './SelectTeam.vue'
const router = createRouter({
  routes: [{
    path: '/',
    component: Main
  },
  {
    path: '/selectTeam',
    component: SelectTeam
  }
],
  history: createWebHistory()
})

const app = createApp(App)
app.use(router)
app.mount('#app')