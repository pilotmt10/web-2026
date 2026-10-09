<script setup>
  defineProps({
    product: {}
  })
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
          <button class="btn-buy">Купить</button>
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