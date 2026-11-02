<script setup>

import {ref} from "vue";

const email = ref('')
const password = ref('')
const errors = ref({
  email: '',
  password: ''
})

const submitForm = () => {
  errors.value.email = ''
  errors.value.password = ''

  if (email.value.trim().length === 0) {
    errors.value.email = 'Заполните Email.'
  }

  if (password.value.trim().length === 0) {
    errors.value.password = 'Заполните пароль.'
  }
}

</script>

<template>
  <div class="container">
    <h1 class="text-center">Авторизация</h1>

    <form class="login-form" @submit.prevent="submitForm">
      <div class="form-group">
        <label>
          Email
          <input
              type="text"
              placeholder="Введите Email"
              v-model="email"
          >
        </label>
        <div class="errors">{{ errors.email }}</div>
      </div>
      <div class="form-group">
        <label>
          Пароль
          <input
              type="password"
              placeholder="Введите пароль"
              v-model="password"
          >
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