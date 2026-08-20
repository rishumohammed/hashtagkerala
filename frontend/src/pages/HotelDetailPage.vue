<script setup>
import { computed, ref, onMounted, reactive } from 'vue'
import { useRoute } from 'vue-router'
import { useHead } from '@unhead/vue'
import { getHotelBySlug } from '../services/hotelApi'
import { apiClient } from '../services/api'
import VueEasyLightbox from 'vue-easy-lightbox'

const route = useRoute()
const hotel = ref(null)
const isLoading = ref(true)
const error = ref(null)
const activeGalleryIndex = ref(0)
const lightboxVisible = ref(false)
const lightboxIndex = ref(0)
const siteSettings = ref({})

const conciergePhone = computed(() => siteSettings.value?.contact_phone || '+91 99611 99229')
const conciergeWhatsApp = computed(() => {
  const raw = siteSettings.value?.contact_phone || '919961199229'
  return raw.replace(/[^0-9]/g, '')
})

const inquiryForm = reactive({ name: '', email: '', phone: '', message: '' })
const isChatOpen = ref(false)
const isSubmitting = ref(false)
const submitSuccess = ref(false)
const submitError = ref('')

const submitInquiry = async () => {
  if (!inquiryForm.name || !inquiryForm.email || !inquiryForm.phone || !inquiryForm.message) {
    submitError.value = 'Please fill out all fields.'
    return
  }
  isSubmitting.value = true
  submitError.value = ''
  submitSuccess.value = false
  try {
    await apiClient.post('/contact', {
      name: inquiryForm.name,
      email: inquiryForm.email,
      phone: inquiryForm.phone,
      subject: `Booking Inquiry: ${hotel.value?.name}`,
      message: inquiryForm.message
    })
    submitSuccess.value = true
    inquiryForm.name = ''
    inquiryForm.email = ''
    inquiryForm.phone = ''
    inquiryForm.message = ''
  } catch (err) {
    submitError.value = err.response?.data?.message || 'Failed to send inquiry. Please try again.'
  } finally {
    isSubmitting.value = false
  }
}

onMounted(async () => {
  isLoading.value = true
  try {
    const [data, settingsData] = await Promise.all([
      getHotelBySlug(route.params.slug),
      apiClient.get('/settings').then(res => res.data).catch(() => ({}))
    ])
    if (!data) throw new Error('Hotel not found')
    hotel.value = data
    siteSettings.value = settingsData || {}
    inquiryForm.message = `I am interested in booking a stay at ${data.name}. Please provide more information about availability and rates.`
  } catch (e) {
    error.value = e
  } finally {
    isLoading.value = false
  }
})

useHead({
  title: computed(() => hotel.value ? `${hotel.value.name} | Hashtag Kerala` : 'Loading Hotel...'),
  meta: [
    { name: 'description', content: computed(() => hotel.value ? hotel.value.description.substring(0, 160) : 'Explore premium stays in Kerala.') },
    { property: 'og:title', content: computed(() => hotel.value?.name) },
    { property: 'og:image', content: computed(() => hotel.value?.image) },
    { name: 'twitter:card', content: 'summary_large_image' }
  ]
})

const galleryImages = computed(() => {
  if (!hotel.value) return []
  const images = []
  if (hotel.value.images && Array.isArray(hotel.value.images)) {
    hotel.value.images.forEach(img => images.push({ url: img.full_url || img.url, title: img.title || 'Hotel View' }))
  } else if (hotel.value.image) {
    images.push({ url: hotel.value.image, title: 'Main View' })
  }
  return images
})

const featuredImage = computed(() => galleryImages.value[activeGalleryIndex.value]?.url || hotel.value?.image || '')
const lightboxImgs = computed(() => galleryImages.value.map(img => img.url))

const openLightbox = (index) => {
  lightboxIndex.value = index
  lightboxVisible.value = true
}
</script>

<template><main>
  <!-- Loading -->
  <div v-if="isLoading" class="flex min-h-[60vh] items-center justify-center">
    <div class="text-center space-y-4">
      <div class="relative mx-auto h-16 w-16">
        <div class="absolute inset-0 rounded-full border-4 border-brand-primary/20"></div>
        <div class="absolute inset-0 animate-spin rounded-full border-4 border-transparent border-t-brand-primary"></div>
      </div>
      <p class="font-sans text-stone-400 text-sm tracking-wider uppercase">Preparing your stay...</p>
    </div>
  </div>

  <!-- Error -->
  <div v-else-if="error" class="flex min-h-[60vh] items-center justify-center px-4">
    <div class="surface-glass max-w-md rounded-[2.5rem] p-12 text-center">
      <h2 class="font-heading text-2xl text-brand-ink">Property not found</h2>
      <p class="mt-3 text-stone-500">{{ error.message }}</p>
      <RouterLink :to="{ name: 'home' }" class="btn-primary mt-8 inline-flex">Back to Home</RouterLink>
    </div>
  </div>

  <!-- Hotel Detail -->
  <div v-else-if="hotel" class="pb-20">

    <!-- CINEMATIC HERO -->
    <section class="relative h-[80vh] max-h-[700px] min-h-[500px] overflow-hidden">
      <div class="absolute inset-0">
        <img v-if="hotel.image" :src="hotel.image" :alt="hotel.name" class="h-full w-full object-cover">
        <div v-else class="h-full w-full" :class="`bg-gradient-to-br ${hotel.tone || 'from-slate-700 via-sky-700 to-cyan-500'}`"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-black/10"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-black/30 to-transparent"></div>
      </div>

      <div class="absolute inset-0 flex flex-col justify-end pb-12 sm:pb-16">
        <div class="shell-container">
          <div class="mb-5 flex items-center gap-2 text-xs font-medium uppercase tracking-widest text-white/60">
            <RouterLink :to="{ name: 'home' }" class="hover:text-white/90 transition-colors">Home</RouterLink>
            <span>/</span>
            <span class="text-white/80">{{ hotel.district }}</span>
            <span>/</span>
            <span class="truncate max-w-[200px] text-white/50">{{ hotel.name }}</span>
          </div>

          <div class="mb-5 flex flex-wrap gap-2">
            <span v-if="hotel.hotel_type" class="inline-flex items-center rounded-full border border-white/25 bg-white/15 px-4 py-1.5 text-xs font-semibold uppercase tracking-wider text-white backdrop-blur-md">{{ hotel.hotel_type }}</span>
            <span class="badge" :class="hotel.priceClass || 'badge-premium'">{{ hotel.category }}</span>
            <span class="inline-flex items-center gap-1.5 rounded-full border border-white/25 bg-white/15 px-4 py-1.5 text-xs font-medium text-white backdrop-blur-md">
              <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
              {{ hotel.location }}
            </span>
          </div>

          <h1 class="font-heading text-5xl leading-none text-white sm:text-6xl lg:text-7xl xl:text-8xl">{{ hotel.name }}</h1>

          <div class="mt-8 flex flex-wrap gap-3">
            <a :href="`https://wa.me/${conciergeWhatsApp}?text=${encodeURIComponent('I am interested in booking a stay at ' + hotel.name + '. Please provide more information about availability and rates.')}`" target="_blank" rel="noreferrer"
              class="inline-flex items-center gap-2 rounded-full bg-[#25D366] px-6 py-3 text-sm font-semibold text-white shadow-lg hover:bg-[#20bd5a] transition-all hover:scale-105 active:scale-95">
              <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.885m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
              WhatsApp
            </a>
            <a :href="`tel:${conciergePhone}`"
              class="inline-flex items-center gap-2 rounded-full border border-white/30 bg-white/15 px-6 py-3 text-sm font-semibold text-white backdrop-blur-md hover:bg-white/25 transition-all hover:scale-105 active:scale-95">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
              Call Concierge
            </a>
            <button @click="isChatOpen = !isChatOpen"
              class="inline-flex items-center gap-2 rounded-full border border-white/30 bg-white/15 px-6 py-3 text-sm font-semibold text-white backdrop-blur-md hover:bg-white/25 transition-all hover:scale-105 active:scale-95">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
              Enquire
            </button>
          </div>
        </div>
      </div>

      <!-- Desktop gallery strip -->
      <div v-if="galleryImages.length > 0" class="absolute bottom-0 right-0 hidden lg:flex items-end gap-2 p-6">
        <div v-for="(img, i) in galleryImages.slice(0, 4)" :key="i"
          class="cursor-pointer overflow-hidden rounded-xl transition-all duration-300"
          :class="activeGalleryIndex === i ? 'ring-2 ring-white w-20 h-14 opacity-100' : 'w-16 h-12 opacity-60 hover:opacity-90 hover:w-20 hover:h-14'"
          @click="activeGalleryIndex = i">
          <img :src="img.url" :alt="img.title" class="h-full w-full object-cover">
        </div>
        <button v-if="galleryImages.length > 4" @click="openLightbox(0)"
          class="flex h-12 w-16 items-center justify-center rounded-xl bg-black/50 backdrop-blur-sm text-white text-xs font-bold hover:bg-black/70 transition-all">
          +{{ galleryImages.length - 4 }}
        </button>
      </div>
    </section>

    <!-- MAIN CONTENT -->
    <div class="shell-container mt-10 sm:mt-14">
      <div class="grid gap-10 lg:grid-cols-[1fr_360px] xl:gap-14">

        <!-- LEFT COLUMN -->
        <div class="min-w-0 space-y-10">

          <!-- Mobile Gallery -->
          <section v-if="galleryImages.length > 0" class="lg:hidden">
            <div class="group relative aspect-[16/10] cursor-pointer overflow-hidden rounded-[2rem] bg-stone-100 shadow-glass"
              @click="openLightbox(activeGalleryIndex)">
              <img :src="featuredImage" alt="Hotel Gallery" class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-105">
              <div class="absolute inset-0 flex items-center justify-center bg-black/0 group-hover:bg-black/20 transition-all duration-500 opacity-0 group-hover:opacity-100">
                <div class="rounded-full bg-white/20 p-4 backdrop-blur-sm border border-white/30">
                  <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
                </div>
              </div>
              <div class="absolute bottom-3 right-3 rounded-full bg-black/50 px-3 py-1 text-xs font-medium text-white backdrop-blur-sm">
                {{ activeGalleryIndex + 1 }} / {{ galleryImages.length }}
              </div>
            </div>
            <div v-if="galleryImages.length > 1" class="mt-3 flex gap-2 overflow-x-auto pb-1 no-scrollbar">
              <button v-for="(img, i) in galleryImages" :key="i"
                class="relative aspect-square w-16 min-w-[4rem] overflow-hidden rounded-xl transition-all duration-200"
                :class="activeGalleryIndex === i ? 'ring-2 ring-brand-secondary scale-95' : 'opacity-60 hover:opacity-90'"
                @click="activeGalleryIndex = i">
                <img :src="img.url" :alt="img.title" class="h-full w-full object-cover">
              </button>
            </div>
          </section>

          <!-- About -->
          <section class="surface-glass rounded-[2.5rem] p-8 sm:p-10 shadow-soft">
            <div class="mb-6 flex items-center gap-3">
              <div class="h-px flex-1 bg-gradient-to-r from-brand-primary/40 to-transparent"></div>
              <span class="eyebrow">About this Stay</span>
              <div class="h-px flex-1 bg-gradient-to-l from-brand-primary/40 to-transparent"></div>
            </div>
            <h2 class="section-heading text-3xl sm:text-4xl mb-5">{{ hotel.name }}</h2>
            <p class="text-base leading-9 text-stone-600 dark:text-stone-300 whitespace-pre-wrap">{{ hotel.description }}</p>
            <div v-if="(hotel.tagNames || hotel.tags || []).length" class="mt-6 flex flex-wrap gap-2">
              <span v-for="tag in (hotel.tagNames || hotel.tags || [])" :key="tag" class="tag">#{{ tag }}</span>
            </div>
          </section>

          <!-- Amenities -->
          <section v-if="hotel.amenities && hotel.amenities.length > 0" class="surface-glass rounded-[2.5rem] p-8 sm:p-10 shadow-soft">
            <div class="mb-7 flex items-center gap-3">
              <div class="h-px flex-1 bg-gradient-to-r from-brand-primary/40 to-transparent"></div>
              <span class="eyebrow">Property Amenities</span>
              <div class="h-px flex-1 bg-gradient-to-l from-brand-primary/40 to-transparent"></div>
            </div>
            <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4">
              <div v-for="(amenity, i) in hotel.amenities" :key="i"
                class="group flex flex-col items-center gap-2.5 rounded-2xl border border-brand-line/60 bg-white/50 p-5 text-center transition-all duration-300 hover:border-brand-primary/30 hover:bg-brand-mist hover:-translate-y-0.5 hover:shadow-soft dark:border-white/10 dark:bg-white/5">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-brand-primary/10 group-hover:bg-brand-primary/20 transition-colors" v-html="amenity.icon">
                </div>
                <span class="text-xs font-semibold leading-tight text-stone-600 dark:text-stone-300">{{ amenity.name || amenity }}</span>
              </div>
            </div>
          </section>

          <!-- Features & Room Types -->
          <div class="grid gap-6 sm:grid-cols-2">
            <section v-if="hotel.features && hotel.features.length > 0" class="surface-glass rounded-[2.5rem] p-8 shadow-soft">
              <h3 class="font-heading text-xl text-brand-ink dark:text-white mb-5">Room Features</h3>
              <div class="space-y-3">
                <div v-for="feature in hotel.features" :key="feature" class="flex items-center gap-3 text-sm text-stone-600 dark:text-stone-300">
                  <div class="flex h-6 w-6 min-w-[1.5rem] items-center justify-center rounded-full bg-sky-100 dark:bg-sky-900/30">
                    <svg class="w-3.5 h-3.5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                  </div>
                  {{ feature }}
                </div>
              </div>
            </section>

            <section v-if="hotel.room_types && hotel.room_types.length > 0" class="surface-glass rounded-[2.5rem] p-8 shadow-soft">
              <h3 class="font-heading text-xl text-brand-ink dark:text-white mb-5">Room Types</h3>
              <div class="space-y-3">
                <div v-for="room in hotel.room_types" :key="room"
                  class="flex items-center gap-3 rounded-xl border border-brand-line/60 bg-white/60 px-4 py-3 text-sm font-medium text-stone-700 dark:border-white/10 dark:bg-white/5 dark:text-stone-300">
                  <svg class="w-4 h-4 flex-shrink-0 text-brand-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/></svg>
                  {{ room }}
                </div>
              </div>
            </section>
          </div>

          <!-- Nearby & How to Reach -->
          <div v-if="hotel.nearby_attractions || hotel.how_to_reach" class="grid gap-6 sm:grid-cols-2">
            <section v-if="hotel.nearby_attractions" class="surface-glass rounded-[2.5rem] p-8 shadow-soft">
              <div class="mb-4 flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-100 dark:bg-emerald-900/30">
                  <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z"/></svg>
                </div>
                <h3 class="font-heading text-xl text-brand-ink dark:text-white">Nearby Attractions</h3>
              </div>
              <div class="space-y-2">
                <div v-for="line in hotel.nearby_attractions.split('\n').filter(l => l.trim())" :key="line" class="flex items-start gap-2 text-sm text-stone-600 dark:text-stone-300">
                  <span class="mt-1.5 h-1.5 w-1.5 min-w-[0.375rem] rounded-full bg-emerald-400"></span>
                  <span>{{ line }}</span>
                </div>
              </div>
            </section>

            <section v-if="hotel.how_to_reach" class="surface-glass rounded-[2.5rem] p-8 shadow-soft">
              <div class="mb-4 flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-sky-100 dark:bg-sky-900/30">
                  <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/></svg>
                </div>
                <h3 class="font-heading text-xl text-brand-ink dark:text-white">How to Reach</h3>
              </div>
              <div class="space-y-2">
                <div v-for="line in hotel.how_to_reach.split('\n').filter(l => l.trim())" :key="line" class="flex items-start gap-2 text-sm text-stone-600 dark:text-stone-300">
                  <span class="mt-1.5 h-1.5 w-1.5 min-w-[0.375rem] rounded-full bg-sky-400"></span>
                  <span>{{ line }}</span>
                </div>
              </div>
            </section>
          </div>

          <!-- Photo Gallery Grid -->
          <section v-if="galleryImages.length > 1">
            <div class="mb-6 flex items-center justify-between">
              <h2 class="section-heading text-2xl sm:text-3xl">Photo Gallery</h2>
              <button @click="openLightbox(0)" class="text-sm font-medium text-brand-secondary hover:text-brand-primary transition-colors">
                View all {{ galleryImages.length }} →
              </button>
            </div>
            <div class="grid gap-3 grid-cols-2 sm:grid-cols-3">
              <div v-for="(img, i) in galleryImages" :key="i"
                class="group relative cursor-pointer overflow-hidden bg-stone-100 shadow-sm transition-all duration-300 hover:shadow-glass hover:-translate-y-0.5"
                :class="i === 0 ? 'col-span-2 row-span-2 rounded-[1.5rem] aspect-[4/3]' : 'rounded-2xl aspect-square'"
                @click="openLightbox(i)">
                <img :src="img.url" :alt="img.title" loading="lazy" class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110">
                <div class="absolute inset-0 flex items-center justify-center bg-black/0 group-hover:bg-black/20 transition-colors duration-500 opacity-0 group-hover:opacity-100">
                  <svg class="w-6 h-6 text-white drop-shadow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                </div>
              </div>
            </div>
          </section>

        </div>

        <!-- RIGHT SIDEBAR -->
        <aside>
          <div class="surface-glass sticky top-24 rounded-[2.5rem] p-7 shadow-glass">
            <div class="mb-6">
              <p class="text-xs font-semibold uppercase tracking-widest text-stone-400">Plan Your Visit</p>
              <h2 class="mt-1 font-heading text-2xl text-brand-ink dark:text-white">Book This Stay</h2>
            </div>

            <div class="mb-7 space-y-3 rounded-2xl bg-stone-50/70 dark:bg-white/5 p-4">
              <div class="flex items-center gap-3 text-sm text-stone-600 dark:text-stone-400">
                <svg class="w-4 h-4 flex-shrink-0 text-brand-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                {{ hotel.location }}, {{ hotel.district }}
              </div>
              <div v-if="hotel.hotel_type" class="flex items-center gap-3 text-sm text-stone-600 dark:text-stone-400">
                <svg class="w-4 h-4 flex-shrink-0 text-brand-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/></svg>
                {{ hotel.hotel_type }}
              </div>
            </div>

            <div class="flex flex-col gap-3">
              <a :href="`https://wa.me/${conciergeWhatsApp}?text=${encodeURIComponent('I am interested in booking a stay at ' + hotel.name + '. Please provide more information about availability and rates.')}`" target="_blank" rel="noreferrer"
                class="flex h-14 items-center justify-center gap-2 rounded-2xl bg-[#25D366] text-sm font-semibold text-white shadow-soft transition-all hover:bg-[#20bd5a] hover:-translate-y-0.5 active:scale-95">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.885m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                Chat on WhatsApp
              </a>
              <button @click="isChatOpen = true" class="btn-outline flex h-14 items-center justify-center gap-2 rounded-2xl">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                Send Inquiry Email
              </button>
            </div>

            <div class="mt-6 flex items-center justify-center gap-4 border-t border-stone-100/80 dark:border-white/10 pt-5">
              <div class="text-center text-xs text-stone-400"><div class="font-semibold text-stone-500 dark:text-stone-300">Free</div>Inquiry</div>
              <div class="h-6 w-px bg-stone-200 dark:bg-white/10"></div>
              <div class="text-center text-xs text-stone-400"><div class="font-semibold text-stone-500 dark:text-stone-300">Quick</div>Response</div>
              <div class="h-6 w-px bg-stone-200 dark:bg-white/10"></div>
              <div class="text-center text-xs text-stone-400"><div class="font-semibold text-stone-500 dark:text-stone-300">Verified</div>Property</div>
            </div>
          </div>
        </aside>
      </div>
    </div>

    <!-- Lightbox -->
    <vue-easy-lightbox :visible="lightboxVisible" :imgs="lightboxImgs" :index="lightboxIndex" @hide="lightboxVisible = false" />

    <!-- Floating Chat Widget -->
    <div v-if="hotel" class="fixed bottom-6 right-6 z-50 flex flex-col items-end">
      <Transition name="chat-slide">
        <div v-if="isChatOpen" class="mb-4 flex w-[22rem] flex-col overflow-hidden rounded-3xl border border-stone-200/80 bg-white shadow-2xl origin-bottom-right dark:border-white/10 dark:bg-stone-900">
          <div class="flex items-center justify-between bg-brand-secondary px-5 py-4">
            <div class="flex items-center gap-2.5">
              <div class="flex h-8 w-8 items-center justify-center rounded-full bg-white/10">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
              </div>
              <div>
                <p class="text-sm font-bold text-white">Send an Inquiry</p>
                <p class="text-[10px] text-white/60">{{ hotel.name }}</p>
              </div>
            </div>
            <button @click="isChatOpen = false" class="text-white/60 hover:text-white transition-all hover:rotate-90">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
          </div>
          <div class="p-5 bg-stone-50 dark:bg-stone-800/50">
            <p class="mb-4 text-sm text-stone-500">Leave us a message and we'll get back to you shortly.</p>
            <form class="space-y-3" @submit.prevent="submitInquiry">
              <div v-if="submitSuccess" class="rounded-xl bg-emerald-50 p-3 text-xs text-emerald-700 border border-emerald-200">
                Inquiry sent! We'll get back to you soon.
              </div>
              <div v-if="submitError" class="rounded-xl bg-red-50 p-3 text-xs text-red-700 border border-red-200">{{ submitError }}</div>
              <div class="relative">
                <input v-model="inquiryForm.name" class="input-field pl-9 text-sm py-3" type="text" placeholder="Your name" required :disabled="isSubmitting">
                <svg class="absolute left-3 top-3.5 w-4 h-4 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
              </div>
              <div class="relative">
                <input v-model="inquiryForm.email" class="input-field pl-9 text-sm py-3" type="email" placeholder="Email address" required :disabled="isSubmitting">
                <svg class="absolute left-3 top-3.5 w-4 h-4 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
              </div>
              <div class="relative">
                <input v-model="inquiryForm.phone" class="input-field pl-9 text-sm py-3" type="tel" placeholder="Phone number" required :disabled="isSubmitting">
                <svg class="absolute left-3 top-3.5 w-4 h-4 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
              </div>
              <textarea v-model="inquiryForm.message" class="input-field resize-none text-sm" rows="3" placeholder="Travel dates, group size..." required :disabled="isSubmitting"></textarea>
              <button type="submit" class="btn-primary w-full rounded-xl py-3 text-sm font-bold" :disabled="isSubmitting">
                <span v-if="isSubmitting">Sending...</span>
                <span v-else>Send Message</span>
              </button>
            </form>
          </div>
        </div>
      </Transition>
      <Transition name="fade">
        <button v-if="!isChatOpen" @click="isChatOpen = true"
          class="flex h-16 w-16 items-center justify-center rounded-full bg-brand-secondary text-white shadow-2xl transition-all hover:scale-110 active:scale-95 hover:bg-brand-primary">
          <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
        </button>
      </Transition>
    </div>

  </div>
</main></template>

<style scoped>
.chat-slide-enter-active, .chat-slide-leave-active {
  transition: all 0.35s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}
.chat-slide-enter-from, .chat-slide-leave-to {
  opacity: 0;
  transform: translateY(16px) scale(0.92);
}
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.25s ease, transform 0.25s ease;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
  transform: scale(0.8);
}
</style>

