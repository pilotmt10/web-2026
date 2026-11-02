<script setup>

import {ref} from "vue";

defineProps({
  product: {}
})

const inCart = ref(false)

const buy = (id) => {
  inCart.value = !inCart.value
}

</script>

<template>
  <router-link to="/" class="no-link">
    <div class="product-item">
      <img src="@/assets/img/image.jpg">
      <div class="product-info">
        <div class="price-container">
          <span class="general-price">{{ product.price }} ₽</span>
          <del class="old-price">{{ product.oldPrice }} ₽</del>
        </div>
        <p>{{ product.name }}</p>
        <div>
          <button class="btn-buy" v-if="!inCart" @click="buy(product.id)">Купить</button>
          <button class="btn-in-cart" v-if="inCart">Добавлен</button>
        </div>
      </div>
    </div>
  </router-link>
</template>

<style scoped>
  .product-item {
    background-color: #fff;
    color: var(--text-primary);
    border-radius: var(--border);
    overflow: hidden;
    box-shadow: 0 0 5px #eee;
  }

  .product-item .product-info {
    margin: 10px;
  }

  .product-item .product-info .price-container {
    display: flex;
    align-items: baseline;
  }

  .product-item .product-info .general-price {
    font-weight: bold;
    font-size: 20px;
    color: var(--color-acent);
  }

  .product-item .product-info .old-price {
    font-weight: bold;
    color: var(--color-secondary);
    margin-left: 10px;
  }

  .product-item .product-info .btn-in-cart {
    width: 100%;
    text-transform: uppercase;
    color: #fff;
    font-size: 16px;
    border: none;
    padding: 15px 25px;
    border-radius: var(--border);
    background-color: orange;
  }

  .product-item .product-info .btn-buy {
    width: 100%;
    background-color: var(--primary-color);
    text-transform: uppercase;
    color: #fff;
    font-size: 16px;
    border: none;
    padding: 15px 25px;
    border-radius: var(--border);
  }

  .product-item img {
    width: 100%;
  }
</style>