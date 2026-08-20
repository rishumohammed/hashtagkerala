<template>
  <div class="hotel-gallery mt-8 space-y-4">
    <!-- Featured Image -->
    <div 
      class="group relative aspect-[3/2] w-full overflow-hidden rounded-[2rem] bg-slate-100 cursor-pointer shadow-glass transition-all duration-700 hover:shadow-2xl"
      @click="showImg(activeIndex)"
    >
      <img 
        :src="featuredImage" 
        :alt="'Featured View'"
        class="h-full w-full object-cover transition-transform duration-1000 group-hover:scale-105"
      >
      <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors duration-500 flex items-center justify-center opacity-0 group-hover:opacity-100">
        <div class="bg-white/20 backdrop-blur-md p-4 rounded-full border border-white/30">
          <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
        </div>
      </div>
    </div>

    <!-- Thumbnails Grid -->
    <div v-if="images.length > 1" class="grid grid-cols-4 sm:grid-cols-6 lg:grid-cols-8 gap-3">
      <div 
        v-for="(img, index) in images" 
        :key="index"
        class="relative aspect-square overflow-hidden rounded-xl border-2 transition-all duration-300 cursor-pointer"
        :class="activeIndex === index ? 'border-brand-secondary ring-2 ring-brand-secondary/20 scale-95' : 'border-transparent opacity-70 hover:opacity-100 hover:scale-105'"
        @click="activeIndex = index"
      >
        <img 
          :src="img.full_url || img.url" 
          :alt="img.title || 'Hotel Image'"
          loading="lazy"
          class="h-full w-full object-cover"
        >
      </div>
    </div>

    <!-- Lightbox -->
    <vue-easy-lightbox
      :visible="visibleRef"
      :imgs="imgsRef"
      :index="indexRef"
      @hide="handleHide"
    />
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import VueEasyLightbox from 'vue-easy-lightbox'

const props = defineProps({
  images: {
    type: Array,
    required: true
  }
})

const activeIndex = ref(0)
const visibleRef = ref(false)
const indexRef = ref(0)

const featuredImage = computed(() => {
  const img = props.images[activeIndex.value]
  return img ? (img.full_url || img.url) : ''
})

const imgsRef = computed(() => props.images.map(img => img.full_url || img.url))

const showImg = (index) => {
  indexRef.value = index
  visibleRef.value = true
}

const handleHide = () => {
  visibleRef.value = false
}
</script>

<style scoped>
.hotel-gallery {
  min-height: 300px;
}
</style>
