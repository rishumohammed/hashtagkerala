<script setup>
import { onMounted, ref } from 'vue'
import { useRoute } from 'vue-router'
import { useHead } from '@unhead/vue'
import { apiClient } from '../services/api'

const route = useRoute()
const article = ref(null)
const isLoading = ref(true)

onMounted(async () => {
  try {
    const res = await apiClient.get(`/news/${route.params.slug}`)
    article.value = res.data
  } catch (e) {
    console.error('Failed to load article detail:', e)
  } finally {
    isLoading.value = false
  }
})

useHead({
  title: () => article.value ? `${article.value.title} | Tourism News` : 'Loading... | Hashtag Kerala',
  meta: [
    { name: 'description', content: () => article.value ? article.value.title : 'Read the latest tourism news from Kerala.' }
  ]
})
</script>

<template>
  <div class="pb-20">
    <div v-if="isLoading" class="mx-auto max-w-4xl animate-pulse space-y-10 px-5 pt-32 lg:px-0">
       <div class="h-10 w-3/4 rounded bg-stone-100 dark:bg-stone-800"></div>
       <div class="aspect-video rounded-[3rem] bg-stone-100 dark:bg-stone-800"></div>
       <div class="space-y-4">
          <div class="h-4 w-full rounded bg-stone-100 dark:bg-stone-800"></div>
          <div class="h-4 w-full rounded bg-stone-100 dark:bg-stone-800"></div>
          <div class="h-4 w-2/3 rounded bg-stone-100 dark:bg-stone-800"></div>
       </div>
    </div>

    <article v-else-if="article" class="space-y-12 px-5 pt-32 lg:px-0">
      <header class="mx-auto max-w-4xl space-y-8 text-center">
        <div class="space-y-4">
           <span class="eyebrow text-brand-secondary">{{ article.category || 'Tourism News' }}</span>
           <h1 class="font-heading text-5xl leading-tight text-stone-900 sm:text-7xl dark:text-white">{{ article.title }}</h1>
        </div>
        
        <div class="flex items-center justify-center gap-4 text-sm font-medium text-stone-500">
           <span>{{ new Date(article.published_at || article.created_at).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' }) }}</span>
           <span class="h-1 w-1 rounded-full bg-stone-300"></span>
           <span>5 min read</span>
        </div>
      </header>

      <div class="mx-auto max-w-6xl overflow-hidden rounded-[3rem] border border-white/20 shadow-glass">
         <img :src="article.image" :alt="article.title" class="h-full w-full object-cover max-h-[70vh]" />
      </div>

      <div class="prose prose-stone prose-lg dark:prose-invert mx-auto max-w-3xl px-2">
         <div v-html="article.content"></div>
      </div>
      
      <div class="mx-auto max-w-3xl border-t border-stone-200 pt-10 dark:border-stone-800">
         <div class="flex items-center justify-between">
            <RouterLink :to="{ name: 'news' }" class="btn-ghost">
               ← Back to all news
            </RouterLink>
            <div class="flex gap-4">
               <button class="h-10 w-10 flex items-center justify-center rounded-full border border-stone-200 hover:bg-stone-50 dark:border-stone-800 dark:hover:bg-white/5">
                  <span class="sr-only">Share</span>
                  <!-- Share Icon placeholder -->
                  <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" /></svg>
               </button>
            </div>
         </div>
      </div>
    </article>

    <div v-else class="py-40 text-center">
       <h1 class="font-heading text-4xl">Article not found</h1>
       <RouterLink :to="{ name: 'news' }" class="btn-primary mt-8">Back to News</RouterLink>
    </div>
  </div>
</template>
