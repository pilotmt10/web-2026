<script setup lang="ts">
</script>
<template>
  <header>
    <div class="container">
      <router-link to="/"><img class="logo" src="@/assets/img/logo.png"></router-link>

      <nav>
        <ul>
          <li>
            <router-link to="/">Главная</router-link>
          </li>
          <li>
            <router-link to="/catalog">Каталог</router-link>
          </li>
          <li>
            <router-link to="/login">Войти</router-link>
          </li>
        </ul>
      </nav>
    </div>
  </header>
</template>

<style scoped>
  header {
    background-color: #fff;
  }

  header > .container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 5px 0;
  }

  header .logo {
    width: 100px;
  }

  nav ul {
    display: flex;
    gap: 15px;
    list-style: none;
  }

  nav ul li a {
    text-decoration: none;
    color: var(--color-gray);
  }

  nav ul li a:hover {
    color: var(--primary-color);
  }

  .router-link-active {
    color: var(--primary-color);
  }
</style>