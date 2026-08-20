<script setup>
import { computed, onMounted, ref, onBeforeUnmount, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useHead } from '@unhead/vue'
import { storeToRefs } from 'pinia'
import { priceOptions } from '../services/hotels'
import { getDistricts } from '../services/hotelApi'
import { useHotelFiltersStore } from '../stores/hotelFilters'

const route = useRoute()
const router = useRouter()
const hotelFiltersStore = useHotelFiltersStore()
const { error, hotels, isLoading, priceCategory } = storeToRefs(hotelFiltersStore)

const districts = ref([])

onMounted(async () => {
  try {
    districts.value = await getDistricts()
  } catch (err) {
    console.error(err)
  }
})

const districtSlug = computed(() => route.params.slug || 'alleppey')

const district = computed(() => {
  return districts.value.find(d => d.slug === districtSlug.value) || { title: '', subtitle: '' }
})

watch(
  districtSlug,
  (slug) => {
    hotelFiltersStore.setFilters({ selectedDistrict: slug })
  },
  { immediate: true },
)

onBeforeUnmount(() => {
  hotelFiltersStore.clearPendingRequest()
})

// SEO
useHead({
  title: computed(() => district.value ? `${district.value.title} Hotels | Hashtag Kerala` : 'Districts | Hashtag Kerala'),
  meta: [
    {
      name: 'description',
      content: computed(() => district.value ? district.value.subtitle : 'Discover the best stays in Kerala districts.')
    },
    { property: 'og:title', content: computed(() => district.value?.title) },
    { property: 'og:description', content: computed(() => district.value?.subtitle) },
  ]
})
</script>

<template>
  <section class="space-y-8 sm:space-y-10">
    <div class="space-y-4">
      <span class="eyebrow">District listing</span>
      <div class="space-y-3">
        <h1 class="font-heading text-4xl text-brand-ink sm:text-5xl lg:text-6xl dark:text-white">
          {{ district.title }}
        </h1>
        <p class="max-w-3xl text-sm leading-7 text-stone-600 sm:text-base dark:text-stone-300">
          {{ district.subtitle }}
        </p>
      </div>
    </div>

    <div class="sticky top-20 z-20 rounded-[1.75rem] border border-white/60 bg-white/75 p-6 shadow-glass backdrop-blur-xl dark:border-white/10 dark:bg-stone-950/72">
      <div class="grid gap-6 lg:grid-cols-[1.5fr_1fr_auto] lg:items-end">
        <div class="space-y-3">
          <label for="district-select" class="block text-xs font-semibold uppercase tracking-[0.22em] text-stone-500 dark:text-stone-400">Select District</label>
          <select
            id="district-select"
            :value="districtSlug"
            @change="router.push({ name: 'district', params: { slug: $event.target.value } })"
            class="w-full cursor-pointer appearance-none rounded-[1rem] border border-brand-line bg-white/75 px-4 py-2.5 pr-10 text-sm font-medium text-stone-700 shadow-sm transition-colors focus:border-brand-secondary focus:outline-none focus:ring-1 focus:ring-brand-secondary/20 dark:border-white/10 dark:bg-white/6 dark:text-stone-300 dark:focus:border-brand-secondary/50 sm:w-64"
            style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%236b7280%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right 1rem top 50%; background-size: 0.65rem auto;"
          >
            <option
              v-for="info in districts"
              :key="info.slug"
              :value="info.slug"
              class="dark:bg-stone-900"
            >
              {{ info.title }}
            </option>
          </select>
        </div>

        <div class="space-y-3">
          <p class="text-xs font-semibold uppercase tracking-[0.22em] text-stone-500 dark:text-stone-400">Price category</p>
          <div class="flex flex-wrap gap-2">
            <button
              v-for="option in priceOptions"
              :key="option"
              type="button"
              class="rounded-full px-4 py-2 text-sm font-medium transition"
              :class="priceCategory === option ? 'bg-brand-secondary text-white' : 'border border-brand-line bg-white/75 text-stone-600 hover:border-brand-secondary/30 hover:text-brand-secondary dark:border-white/10 dark:bg-white/6 dark:text-stone-300 dark:hover:text-white'"
              @click="hotelFiltersStore.setFilters({ priceCategory: option })"
            >
              {{ option }}
            </button>
          </div>
        </div>

        <p class="text-sm font-medium text-stone-500 dark:text-stone-400">
          {{ hotels.length }} hotels found
        </p>
      </div>
    </div>

    <div v-if="isLoading" class="rounded-[1.5rem] border border-white/60 bg-white/60 px-5 py-4 text-sm text-stone-500 shadow-soft backdrop-blur-sm dark:border-white/10 dark:bg-white/6 dark:text-stone-300">
      Updating hotels...
    </div>

    <div v-else-if="error" class="rounded-[1.5rem] border border-amber-200 bg-amber-50/90 px-5 py-4 text-sm text-amber-800 shadow-soft backdrop-blur-sm dark:border-amber-500/30 dark:bg-amber-500/10 dark:text-amber-100">
      {{ error.message }} Showing available local results for now.
    </div>

    <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4">
      <RouterLink
        v-for="hotel in hotels"
        :key="hotel.name"
        :to="{ name: 'hotel', params: { district: hotel.district_slug, slug: hotel.slug } }"
        class="group overflow-hidden rounded-[2rem] border border-white/60 bg-white/65 shadow-glass backdrop-blur-xl transition duration-500 hover:-translate-y-1 dark:border-white/10 dark:bg-white/8"
      >
        <div class="relative h-64 overflow-hidden">
          <img :src="hotel.image" :alt="hotel.name" class="absolute inset-0 h-full w-full object-cover transition duration-700 group-hover:scale-110" loading="lazy">
          <div class="absolute inset-x-0 bottom-0 bg-stone-950/40 p-5 text-white backdrop-blur-md">
            <span class="badge" :class="hotel.priceClass">{{ hotel.priceCategory }}</span>
            <div class="mt-4 space-y-1">
              <h2 class="font-heading text-2xl text-white">
                {{ hotel.name }}
              </h2>
              <p class="text-xs uppercase tracking-[0.2em] text-white/80">
                {{ hotel.location }}
              </p>
            </div>
          </div>
        </div>
      </RouterLink>
    </div>
  </section>
</template>
