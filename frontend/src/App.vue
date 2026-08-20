<script setup>
import { computed } from 'vue'
import { useRoute } from 'vue-router'
import BaseLayout from './layouts/BaseLayout.vue'

const route = useRoute()

const layouts = {
  BaseLayout
}

const layout = computed(() => {
  return layouts[route.meta?.layout] || BaseLayout
})
</script>

<template>
  <component :is="layout">
    <router-view v-slot="{ Component }">
      <transition name="page" mode="out-in">
        <component :is="Component" />
      </transition>
    </router-view>
  </component>
</template>
