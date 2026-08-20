<script setup>
import AppFooter from '../components/AppFooter.vue'
import AppNavbar from '../components/AppNavbar.vue'
import PageContainer from '../components/PageContainer.vue'
</script>

<template>
  <div class="flex min-h-screen flex-col">
    <AppNavbar />

    <main class="page-shell flex-1">
      <PageContainer>
        <slot />
      </PageContainer>
    </main>

    <AppFooter />
  </div>
</template>
