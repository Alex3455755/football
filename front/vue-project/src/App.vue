
<template>
  <div id="app">
    <!-- Навигация (опционально) -->
    <nav>
      <router-link to="/">Home</router-link>
    </nav>
    
    <!-- Это ОБЯЗАТЕЛЬНО - здесь будут отображаться компоненты маршрутов -->
    <router-view></router-view>
  </div>
</template>