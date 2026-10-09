<script setup>

import ProductItem from "@/components/Product/ProductItem.vue";
import popular from '@/assets/popular.js'
import {ref} from "vue";
import Slider from "@/components/App/Slider.vue";

const products = ref(popular)

</script>

<template>
   <Slider />

    <div class="container">
      <section class="products-container">
        <ProductItem
          v-for="item in products"
          :product="item"
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