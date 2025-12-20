
<template>
  <div id="app">
    <!-- Навигация (опционально) -->
    <nav>
      <router-link to="/">Home</router-link>
      <router-link to="/selectTeam">SelectTeam</router-link>
    </nav>

    
    <router-view></router-view>
  </div>
</template>