<script setup>

import ProductItem from "@/components/Product/ProductItem.vue";
import Slider from "@/components/App/Slider.vue";
import catalog from "@/assets/popular.js"

const products = catalog

</script>

<template>
   <Slider />

    <div class="container">
      <section class="products-container">
        <ProductItem
            v-for="product in products"
            :product="product"
        />
      </section>
    </div>
</template>

<style scoped>
  .products-container {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 15px;
  }
</style>