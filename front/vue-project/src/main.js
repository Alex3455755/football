import { createApp } from 'vue'
import { createRouter, createWebHistory } from 'vue-router'
import App from './App.vue'
import Main from './Main.vue'
const router = createRouter({
  routes: [{
    path: '/',
    component: Main
  }],
  history: createWebHistory()
})

const app = createApp(App)
app.use(router)
app.mount('#app')