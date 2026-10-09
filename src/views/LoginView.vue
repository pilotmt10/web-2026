<script setup lang="ts">
  import {ref} from "vue";

  const login = ref('')
  const password = ref('')
  const errors = ref({login: '', password: ''})

  const submit = () => {
    errors.value.login = ''
    errors.value.password = ''

    if (login.value.trim().length === 0) {
      errors.value.login = 'Вы забыли ввести email.'
    }

    if (password.value.trim().length === 0) {
      errors.value.password = 'Вы забыли ввести пароль.'
    }
  }
</script>

<template>
  <div class="container">
    <h1 class="text-center">Авторизация</h1>
    <form @submit.prevent="submit" class="login-form">
      <div class="form-group">
        <label>
          Email
          <input type="text" placeholder="Введите Email" v-model="login">
        </label>
        <div class="errors">{{ errors.login }}</div>
      </div>
      <div class="form-group">
        <label>
          Пароль
          <input type="password" placeholder="Введите пароль" v-model="password">
        </label>
        <div class="errors">{{ errors.password }}</div>
      </div>
      <div class="form-group mt-25">
        <button type="submit">Войти</button>
      </div>
    </form>
  </div>
</template>

<style scoped>
  h1 {
    margin-top: 40px;
  }

  .login-form {
    width: 400px;
    margin: 0 auto;
    background-color: #fff;
    padding: 40px;
    border-radius: var(--border);
  }

  .login-form .form-group {
    margin-bottom: 15px;
  }

  .login-form input {
    width: calc(100% - 50px);
    background-color: #f5f5f5;
    border: none;
    padding: 15px 25px;
    margin-top: 5px;
    border-radius: var(--border);
  }

  .login-form label {
    font-weight: bold;
  }

  .login-form button {
    width: 100%;
    background-color: var(--primary-color);
    padding: 15px 25px;
    color: #fff;
    border: none;
    border-radius: var(--border);
  }

  .login-form .errors {
    font-size: 12px;
    color: red;
  }

  .mt-25 {
    margin-top: 25px;
  }
</style>