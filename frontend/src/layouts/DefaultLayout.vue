<script setup>

import Header from "@/components/App/Header.vue";
import Footer from "@/components/App/Footer.vue";

</script>

<template>
  <Header />

  <main>
    <RouterView />
  </main>

  <Footer />
</template>