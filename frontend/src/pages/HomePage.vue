<script setup>
import { onMounted, ref } from 'vue'
import { useHead } from '@unhead/vue'
import { getDistricts, getHotels } from '../services/hotelApi'
import { createRequestState, apiClient } from '../services/api'

const districts = ref([])
const featuredHotels = ref([])
const requestState = createRequestState()
const { loading: isLoading, error } = requestState

const galleryItems = ref([])
const settings = ref({
  hero_youtube_id: 'm7CR9A2sgok', // User-provided Kerala tourism video
})

onMounted(async () => {
  try {
    const [distResponse, hotelsResponse, settingsResponse, galleryResponse] = await Promise.all([
      getDistricts({ state: requestState }),
      getHotels({}, { state: requestState }),
      apiClient.get('/settings').then(res => res.data).catch(() => ({})),
      apiClient.get('/gallery').then(res => res.data).catch(() => ([]))
    ])
    districts.value = distResponse
    featuredHotels.value = hotelsResponse.filter(h => h.is_featured).slice(0, 4)
    if (featuredHotels.value.length === 0) {
      featuredHotels.value = hotelsResponse.slice(0, 4) // Fallback if no hotels are featured
    }
    galleryItems.value = galleryResponse
    if (settingsResponse.hero_youtube_id) {
      settings.value.hero_youtube_id = settingsResponse.hero_youtube_id
    }
    if (settingsResponse.district_card_label) {
      settings.value.district_card_label = settingsResponse.district_card_label
    }
    if (settingsResponse.hotel_categories) {
      try {
        const dynamicCats = JSON.parse(settingsResponse.hotel_categories)
        if (Array.isArray(dynamicCats) && dynamicCats.length > 0) {
          const descMap = {
              'Budget':   'Clean essentials, strong locations, and smart nightly rates for short and flexible stays.',
              'Standard': 'Balanced comfort with curated interiors, breakfast options, and dependable guest service.',
              'Premium':  'Signature Kerala stays with standout views, private experiences, and refined hospitality.',
              'Luxury':   'Exclusive retreats with butler service, infinity pools, and immersive cultural settings.',
              '5-Star':   'World-class properties delivering flawless service, gourmet dining, and iconic addresses.',
              'Resort':   'Full-facility resorts blending Kerala nature with spa therapies, pools, and leisure amenities.',
            }
          categories.value = dynamicCats.map(c => ({
            name: c,
            description: descMap[c] ?? `Discover signature ${c} stays curated for your perfect getaway.`,
            badgeClass: `badge-${c.toLowerCase().replace(/[^a-z0-9]/g, '')}`
          }))
        }
      } catch (e) {
        // Fallback to defaults
      }
    }
  } catch (e) {
    console.error('Failed to load homepage data:', e)
  }
})

// SEO
useHead({
  title: 'Hashtag Kerala | Discover Premium Stays & Hidden Gems',
  meta: [
    {
      name: 'description',
      content: 'The ultimate guide to luxury houseboats, misty hill retreats, and heritage boutique hotels across Kerala. Discover your perfect stay.'
    },
    { property: 'og:title', content: 'Hashtag Kerala - Discover the Best of Kerala' },
    { property: 'og:image', content: '/assets/images/hero-kerala.png' }
  ]
})

const categories = ref([
  {
    name: 'Budget',
    description: 'Clean essentials, strong locations, and smart nightly rates for short and flexible stays.',
    badgeClass: 'badge-budget',
  },
  {
    name: 'Standard',
    description: 'Balanced comfort with curated interiors, breakfast options, and dependable guest service.',
    badgeClass: 'badge-standard',
  },
  {
    name: 'Premium',
    description: 'Signature Kerala stays with standout views, private experiences, and refined hospitality.',
    badgeClass: 'badge-premium',
  },
])
</script>

<template>
  <div class="space-y-14 pb-8 sm:space-y-20 sm:pb-12">
    <!-- Hero Section -->
    <section
      id="home"
      class="relative min-h-[calc(100svh-7.5rem)] overflow-hidden rounded-[2.5rem] bg-stone-900 px-5 py-8 text-white shadow-glass sm:px-8 sm:py-10 lg:px-10 lg:py-12"
    >
      <div class="absolute inset-0 z-0 pointer-events-none overflow-hidden rounded-[2.5rem]">
        <iframe
          class="absolute top-1/2 left-1/2 w-[100vw] h-[56.25vw] min-h-[100vh] min-w-[177.77vh] -translate-x-1/2 -translate-y-1/2"
          :src="`https://www.youtube.com/embed/${settings.hero_youtube_id}?autoplay=1&mute=1&controls=0&loop=1&playlist=${settings.hero_youtube_id}&showinfo=0&rel=0&enablejsapi=1`"
          frameborder="0"
          allow="autoplay; encrypted-media"
          allowfullscreen
        ></iframe>
      </div>
      
      <div class="absolute inset-0 z-1 bg-black/20"></div>
      <div class="absolute inset-0 z-1 bg-[linear-gradient(180deg,rgba(17,24,39,0.05),rgba(17,24,39,0.45))]"></div>

      <div class="relative z-10 flex min-h-[calc(100svh-10rem)] flex-col justify-between gap-10">
        <div class="space-y-6 pt-4 sm:pt-8">
          <span class="inline-flex rounded-full bg-white/10 px-4 py-1.5 text-xs font-semibold uppercase tracking-[0.28em] text-white/90 backdrop-blur-md">
            Kerala's Premier Hotel Collection
          </span>

          <div class="space-y-5">
            <h1 class="max-w-4xl text-balance font-heading text-5xl leading-[1.1] sm:text-6xl lg:text-8xl">
              Experience <br /> Hashtag Kerala
            </h1>
            <p class="max-w-2xl text-base leading-8 text-white/90 sm:text-lg">
              Curated luxury stays and misty retreats discovered through a calmer, premium travel lens.
            </p>
          </div>
        </div>


      </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="space-y-10">
      <div class="space-y-3 text-center">
        <span class="eyebrow">Why Hashtag Kerala</span>
        <h2 class="section-heading">A smarter way to discover Kerala</h2>
        <p class="mx-auto max-w-2xl text-sm leading-7 text-stone-600 dark:text-stone-400">
          We go beyond listings — every stay is handpicked, every destination is curated, and every journey is crafted for the modern Kerala traveller.
        </p>
      </div>

      <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Card 1 -->
        <div class="surface-glass group rounded-[1.75rem] p-7 transition duration-300 hover:-translate-y-1">
          <div class="mb-5 flex h-14 w-14 items-center justify-center rounded-2xl bg-brand-primary/15 text-brand-primary transition duration-300 group-hover:bg-brand-primary/25">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-7 w-7">
              <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
            </svg>
          </div>
          <h3 class="font-heading text-xl text-stone-900 dark:text-white">Curated Collection</h3>
          <p class="mt-3 text-sm leading-7 text-stone-500 dark:text-stone-400">
            Every property is hand-selected by our team — no generic listings, only genuine gems with proven hospitality.
          </p>
        </div>

        <!-- Card 2 -->
        <div class="surface-glass group rounded-[1.75rem] p-7 transition duration-300 hover:-translate-y-1">
          <div class="mb-5 flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-500/15 text-emerald-600 dark:text-emerald-400 transition duration-300 group-hover:bg-emerald-500/25">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-7 w-7">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
              <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
            </svg>
          </div>
          <h3 class="font-heading text-xl text-stone-900 dark:text-white">Kerala Experts</h3>
          <p class="mt-3 text-sm leading-7 text-stone-500 dark:text-stone-400">
            Deep local knowledge across all 14 districts — from hidden Wayanad homestays to iconic Alleppey houseboats.
          </p>
        </div>

        <!-- Card 3 -->
        <div class="surface-glass group rounded-[1.75rem] p-7 transition duration-300 hover:-translate-y-1">
          <div class="mb-5 flex h-14 w-14 items-center justify-center rounded-2xl bg-sky-500/15 text-sky-600 dark:text-sky-400 transition duration-300 group-hover:bg-sky-500/25">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-7 w-7">
              <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
            </svg>
          </div>
          <h3 class="font-heading text-xl text-stone-900 dark:text-white">Premium Comfort</h3>
          <p class="mt-3 text-sm leading-7 text-stone-500 dark:text-stone-400">
            Luxury resorts, boutique heritage hotels, and private villas — all offering superior amenities and refined experiences.
          </p>
        </div>

        <!-- Card 4 -->
        <div class="surface-glass group rounded-[1.75rem] p-7 transition duration-300 hover:-translate-y-1">
          <div class="mb-5 flex h-14 w-14 items-center justify-center rounded-2xl bg-purple-500/15 text-purple-600 dark:text-purple-400 transition duration-300 group-hover:bg-purple-500/25">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-7 w-7">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
            </svg>
          </div>
          <h3 class="font-heading text-xl text-stone-900 dark:text-white">Seamless Planning</h3>
          <p class="mt-3 text-sm leading-7 text-stone-500 dark:text-stone-400">
            Compare stays, explore districts, and connect with our concierge — all in one calm, clutter-free experience.
          </p>
        </div>
      </div>
    </section>

    <!-- Districts Section -->

    <section id="districts" class="space-y-6">
      <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
        <div class="space-y-3">
          <span class="eyebrow">District grid</span>
          <h2 class="section-heading">Explore Kerala by district</h2>
        </div>
        <p class="max-w-xl text-sm leading-6 text-stone-600 dark:text-stone-300">
          Browse signature stays district by district, from coastal escapes to tea-country retreats.
        </p>
      </div>

      <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
        <RouterLink
          v-for="district in districts"
          :key="district.title"
          :to="{ name: 'district', params: { slug: district.slug } }"
          class="group overflow-hidden rounded-[1.75rem] border border-white/60 bg-white/60 shadow-glass backdrop-blur-sm transition duration-500 hover:-translate-y-1 dark:border-white/10 dark:bg-white/6"
        >
          <div class="relative h-64 overflow-hidden">
            <img :src="district.image" :alt="district.title" class="absolute inset-0 h-full w-full object-cover transition duration-700 group-hover:scale-110" loading="lazy">
            <div class="absolute inset-0 bg-black/20"></div>
            <div class="absolute inset-0 bg-[linear-gradient(180deg,rgba(0,0,0,0),rgba(0,0,0,0.6))]"></div>
            <div class="absolute inset-x-0 bottom-0 p-5 text-white">
              <h3 class="font-heading text-2xl sm:text-3xl">{{ district.title }}</h3>
              <p class="mt-1.5 text-xs text-white/80 line-clamp-2 leading-relaxed font-sans">{{ district.subtitle }}</p>
            </div>
          </div>
        </RouterLink>
      </div>
    </section>

    <!-- Featured Hotels Section -->
    <section id="explore" class="space-y-6">
      <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
        <div class="space-y-3">
          <span class="eyebrow">Featured hotels</span>
          <h2 class="section-heading">Handpicked stays worth scrolling for</h2>
        </div>
        <a href="#districts" class="btn-ghost w-fit cursor-pointer text-center block">
          View all hotels
        </a>
      </div>

      <div class="no-scrollbar -mx-4 flex snap-x snap-mandatory gap-5 overflow-x-auto px-4 pb-4 sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
        <RouterLink
          v-for="hotel in featuredHotels"
          :key="hotel.name"
          :to="{ name: 'hotel', params: { district: hotel.district_slug || 'alleppey', slug: hotel.slug } }"
          class="hotel-card min-w-[84vw] snap-start sm:min-w-[420px] lg:min-w-[460px] group"
        >
          <div class="relative h-80 overflow-hidden rounded-[2rem] border border-white/40 shadow-glass">
            <img :src="hotel.image" :alt="hotel.name" class="absolute inset-0 h-full w-full object-cover transition duration-700 group-hover:scale-105" loading="lazy">
            <div class="absolute inset-x-0 bottom-0 bg-stone-950/40 p-5 text-white backdrop-blur-md">
              <div class="flex items-start justify-between gap-3">
                <div class="flex flex-wrap items-center gap-2">
                  <span class="badge" :class="hotel.priceClass">{{ hotel.category || hotel.price_category }}</span>
                  <span v-if="hotel.hotel_type" class="rounded-full border border-white/20 bg-white/10 px-3 py-1 text-xs font-medium backdrop-blur-md">
                    {{ hotel.hotel_type }}
                  </span>
                </div>
                <span class="rounded-full bg-white/15 px-3 py-1 text-xs font-medium backdrop-blur-xs whitespace-nowrap">
                  {{ hotel.location }}
                </span>
              </div>

              <div class="mt-4 space-y-1">
                <p class="text-xs uppercase tracking-[0.26em] text-white/80">Featured hotel</p>
                <h3 class="max-w-sm font-heading text-3xl leading-tight">{{ hotel.name }}</h3>
              </div>
            </div>
          </div>
        </RouterLink>
      </div>
    </section>

    <!-- Categories Section -->
    <section class="space-y-6">
      <div class="space-y-3">
        <span class="eyebrow">Categories</span>
        <h2 class="section-heading">Stay styles for every budget</h2>
      </div>

      <div class="grid gap-5 lg:grid-cols-3">
        <article
          v-for="category in categories"
          :key="category.name"
          class="surface-glass rounded-[1.75rem] p-6"
        >
          <span class="badge" :class="category.badgeClass">{{ category.name }}</span>
          <h3 class="mt-5 font-heading text-3xl text-stone-900 dark:text-white">{{ category.name }} stays</h3>
          <p class="mt-3 text-sm leading-7 text-stone-600 dark:text-stone-300">
            {{ category.description }}
          </p>
        </article>
      </div>
    </section>

    <!-- Image Gallery Section -->
    <section id="gallery" class="space-y-8">
      <div class="space-y-3 text-center">
        <span class="eyebrow">Visual Journey</span>
        <h2 class="section-heading">Tourist locations in Kerala</h2>
        <p class="mx-auto max-w-2xl text-sm leading-7 text-stone-600 dark:text-stone-400">
          From the emerald backwaters to the mist-covered peaks of the Western Ghats, witness the soul of God's Own Country.
        </p>
      </div>

      <!-- Loaded: Bento Grid Layout -->
      <div v-if="galleryItems.length" class="space-y-3">
        <!-- Row 1: Large hero left + 2 stacked right -->
        <div class="grid grid-cols-1 gap-3 lg:grid-cols-[1.5fr_1fr]">
          <!-- Hero card -->
          <div
            v-if="galleryItems[0]"
            class="group relative overflow-hidden rounded-[2rem] border border-white/20 shadow-glass"
            style="height: 480px;"
          >
            <img :src="galleryItems[0].image" :alt="galleryItems[0].title"
              class="h-full w-full object-cover transition duration-700 group-hover:scale-105" loading="lazy" />
            <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-black/10 to-transparent"></div>
            <div class="absolute inset-x-0 bottom-0 p-8">
              <span class="mb-2 inline-block rounded-full border border-brand-primary/50 bg-brand-primary/20 px-3 py-1 text-[10px] font-bold uppercase tracking-[0.22em] text-brand-primary backdrop-blur-sm">
                Featured
              </span>
              <h3 class="font-heading text-3xl text-white drop-shadow-lg">{{ galleryItems[0].title }}</h3>
            </div>
          </div>

          <!-- Right column: 2 stacked -->
          <div class="flex flex-col gap-3">
            <div
              v-for="item in galleryItems.slice(1, 3)"
              :key="item.id"
              class="group relative overflow-hidden rounded-[1.75rem] border border-white/20 shadow-glass"
              style="height: 232px;"
            >
              <img :src="item.image" :alt="item.title"
                class="h-full w-full object-cover transition duration-700 group-hover:scale-105" loading="lazy" />
              <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent"></div>
              <div class="absolute inset-x-0 bottom-0 p-6">
                <h3 class="font-heading text-xl text-white drop-shadow-md transition duration-300 translate-y-1 group-hover:translate-y-0">
                  {{ item.title }}
                </h3>
              </div>
            </div>
          </div>
        </div>

        <!-- Row 2: Three equal panoramic cards -->
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
          <div
            v-for="item in galleryItems.slice(3, 6)"
            :key="item.id"
            class="group relative overflow-hidden rounded-[1.75rem] border border-white/20 shadow-glass"
            style="height: 220px;"
          >
            <img :src="item.image" :alt="item.title"
              class="h-full w-full object-cover transition duration-700 group-hover:scale-105" loading="lazy" />
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent"></div>
            <div class="absolute inset-x-0 bottom-0 p-5">
              <h3 class="font-heading text-lg text-white drop-shadow-md">{{ item.title }}</h3>
            </div>
          </div>
        </div>
      </div>

      <!-- Loading skeleton -->
      <div v-else class="space-y-3">
        <div class="grid gap-3 lg:grid-cols-[1.5fr_1fr]">
          <div class="h-[480px] animate-pulse rounded-[2rem] bg-stone-200 dark:bg-stone-800"></div>
          <div class="flex flex-col gap-3">
            <div class="h-[232px] animate-pulse rounded-[1.75rem] bg-stone-200 dark:bg-stone-800"></div>
            <div class="h-[232px] animate-pulse rounded-[1.75rem] bg-stone-200 dark:bg-stone-800"></div>
          </div>
        </div>
        <div class="grid gap-3 sm:grid-cols-3">
          <div v-for="i in 3" :key="i" class="h-[220px] animate-pulse rounded-[1.75rem] bg-stone-200 dark:bg-stone-800"></div>
        </div>
      </div>
    </section>


    <section class="overflow-hidden rounded-[2rem] border border-white/60 bg-white/60 p-6 shadow-glass backdrop-blur-xl sm:p-8 lg:p-10 dark:border-white/10 dark:bg-white/6">
      <div class="grid gap-8 lg:grid-cols-[1.1fr_0.9fr] lg:items-center">
        <div class="space-y-4">
          <span class="eyebrow">Plan your stay</span>
          <h2 class="section-heading max-w-2xl">Ready to shortlist the best hotels across Kerala?</h2>
          <p class="max-w-2xl text-sm leading-7 text-stone-600 dark:text-stone-300 sm:text-base">
            Compare districts, discover featured properties, and build a stay plan that fits your travel style from budget to premium.
          </p>
        </div>

        <div class="flex flex-col gap-5 sm:flex-row sm:items-center lg:justify-end">
          <a href="#districts" class="btn-primary cursor-pointer text-center">Start exploring</a>
          <RouterLink :to="{ name: 'contact' }" class="group flex items-center justify-center text-sm font-medium text-stone-600 transition-colors hover:text-stone-900 dark:text-stone-300 dark:hover:text-white">
            Talk to support
            <svg xmlns="http://www.w3.org/2000/svg" class="ml-1.5 h-4 w-4 transition-transform group-hover:translate-x-1" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
          </RouterLink>
        </div>
      </div>
    </section>
  </div>
</template>
