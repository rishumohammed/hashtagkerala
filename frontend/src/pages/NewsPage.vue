<script setup>
import { onMounted, ref } from 'vue'
import { useHead } from '@unhead/vue'

const articles = ref([])
const isLoading = ref(true)

onMounted(async () => {
  try {
    const res = await fetch('/api/news')
    const data = await res.json()
    articles.value = Array.isArray(data) ? data : []
  } catch (e) {
    console.error('Failed to load news:', e)
  } finally {
    isLoading.value = false
  }
})

useHead({
  title: 'Tourism News | Hashtag Kerala',
  meta: [
    { name: 'description', content: 'Stay updated with the latest news, festivals, and travel advisories from God\'s Own Country.' }
  ]
})
</script>

<template>
  <div class="space-y-16 pb-20">
    <section class="relative h-[40svh] overflow-hidden rounded-[2.5rem] bg-stone-900 border border-white/20 shadow-glass flex items-center justify-center text-center px-5">
       <div class="absolute inset-0 bg-[url('/assets/images/kerala_tea_hills.jpg')] bg-cover bg-center brightness-[0.6] grayscale-[0.2]"></div>
       <div class="relative z-10 space-y-4">
          <span class="eyebrow text-white/80">Stay Updated</span>
          <h1 class="font-heading text-6xl text-white">Tourism News</h1>
       </div>
    </section>

    <section class="mx-auto max-w-7xl px-5 lg:px-10">
      <div v-if="isLoading" class="grid gap-10 md:grid-cols-2 lg:grid-cols-3">
         <div v-for="i in 6" :key="i" class="animate-pulse space-y-4">
            <div class="aspect-video rounded-3xl bg-stone-100 dark:bg-stone-800"></div>
            <div class="h-6 w-3/4 rounded bg-stone-100 dark:bg-stone-800"></div>
            <div class="h-4 w-1/2 rounded bg-stone-100 dark:bg-stone-800"></div>
         </div>
      </div>

      <div v-else-if="articles.length" class="grid gap-12 md:grid-cols-2 lg:grid-cols-3">
        <RouterLink 
          v-for="article in articles" 
          :key="article.slug"
          :to="{ name: 'news-detail', params: { slug: article.slug } }"
          class="group space-y-6"
        >
          <div class="aspect-video overflow-hidden rounded-3xl border border-white/40 shadow-glass transition-all duration-500 group-hover:shadow-glass-lg">
            <img :src="article.image" :alt="article.title" class="h-full w-full object-cover transition duration-700 group-hover:scale-105" />
          </div>
          <div class="space-y-3">
            <span class="text-xs font-semibold uppercase tracking-[0.24em] text-brand-secondary">{{ article.category || 'News' }}</span>
            <h2 class="font-heading text-3xl leading-tight text-stone-900 transition-colors group-hover:text-brand-secondary dark:text-white">{{ article.title }}</h2>
            <p class="line-clamp-3 text-sm leading-7 text-stone-600 dark:text-stone-400" v-html="article.content.substring(0, 150) + '...'"></p>
            <div class="pt-2 text-xs font-medium text-stone-400">
               {{ new Date(article.published_at || article.created_at).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' }) }}
            </div>
          </div>
        </RouterLink>
      </div>

      <div v-else class="py-20 text-center">
         <p class="text-stone-500">No news articles found at the moment. Please check back later.</p>
         <div v-if="!isLoading" class="mt-8">
            <!-- For demonstration: Show some dummy articles if API is empty -->
            <div class="grid gap-12 md:grid-cols-2 lg:grid-cols-3 text-left">
               <article v-for="i in 3" :key="i" class="space-y-6 opacity-60">
                 <div class="aspect-video rounded-3xl bg-stone-100 dark:bg-stone-800"></div>
                 <div class="space-y-3">
                    <h2 class="font-heading text-2xl dark:text-white">Sample Article Title</h2>
                    <p class="text-sm dark:text-stone-400">This content will be managed from the admin panel once you add articles in Filament.</p>
                 </div>
               </article>
            </div>
         </div>
      </div>
    </section>
  </div>
</template>
