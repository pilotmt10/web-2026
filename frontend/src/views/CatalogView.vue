<script setup>

import ProductItem from "@/components/Product/ProductItem.vue";
import catalog from "@/assets/catalog.js"

const products = catalog

</script>

<template>
  <div class="container">
    <h1>Моторные масла</h1>
    <section class="catalog-container">
      <aside class="filters">
        <ul>
          <li>
            <div><strong>Категория</strong></div>
            <ul class="items">
              <li>
                <label><input type="checkbox"> Автотовары</label>
              </li>
              <li>
                <label><input type="checkbox"> Масла и химии</label>
              </li>
              <li>
                <label><input type="checkbox"> Автомобильные моторные масла</label>
              </li>
            </ul>
          </li>
          <li>
            <div><strong>Бренды</strong></div>
            <ul class="items">
              <li>
                <label><input type="checkbox"> Автотовары</label>
              </li>
              <li>
                <label><input type="checkbox"> Автотовары</label>
              </li>
              <li>
                <label><input type="checkbox"> Автотовары</label>
              </li>
              <li>
                <label><input type="checkbox"> Автотовары</label>
              </li>
            </ul>
          </li>
        </ul>
      </aside>
      <div class="products-container">
        <ProductItem
            v-for="product in products"
            :product="product"
        />
      </div>
    </section>
  </div>
</template>

<style scoped>
  .products-container {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 15px;
  }

  .catalog-container {
    display: flex;
  }

  .filters {
    min-width: 240px;
    background-color: #fff;
    padding: 15px;
    margin-right: 15px;
    border-radius: var(--border);
  }

  .filters ul {
    list-style: none;
    padding: 0;
    margin: 0;
    color: var(--text-primary)
  }

  .filters ul li {
    margin-bottom: 15px;
  }

  .filters .items {
    margin-top: 10px;
    padding-left: 25px;
  }

  .filters .items li {
    padding: 5px 0;
    margin: 0;
    color: var(--color-gray)
  }
</style>