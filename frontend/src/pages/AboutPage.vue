<script setup>
import { onMounted, ref } from 'vue'
import { useHead } from '@unhead/vue'
import { apiClient } from '../services/api'

const siteSettings = ref({})
const socialLinks = ref({
  instagram: 'https://www.instagram.com/hashtag_kerala?igsh=MXc2YWowa3JhZnE1NA==',
  facebook: 'https://www.facebook.com/share/1BwppcFDfW/',
  youtube: 'https://youtube.com/@hashtagkerala?si=tHJ1acz_IEmNKeKv',
})

onMounted(async () => {
  try {
    const res = await apiClient.get('/settings')
    const data = res.data
    if (data) {
      siteSettings.value = data
      if (data.social_instagram) socialLinks.value.instagram = data.social_instagram
      if (data.social_youtube) socialLinks.value.youtube = data.social_youtube
      if (data.social_facebook) socialLinks.value.facebook = data.social_facebook
    }
  } catch (e) {
    console.error('Failed to load settings:', e)
  }
})

useHead({
  title: 'About | Hashtag Kerala',
  meta: [
    {
      name: 'description',
      content:
        'Hashtag Kerala is a Kerala-focused travel and hospitality platform founded by Abhijith Mohan. Discover hotels, homestays and experiences across Kerala, district by district.',
    },
  ],
})

const services = [
  {
    icon: 'hotel',
    eyebrow: 'Stay Discovery',
    title: 'Hotel & Stay Discovery',
    description:
      'Explore hotels, resorts, homestays and other accommodation options across Kerala, organised district wise for easy browsing.',
  },
  {
    icon: 'enquiry',
    eyebrow: 'Booking Assistance',
    title: 'Enquiries & Booking Help',
    description:
      'Found a place you like? Send us an enquiry. We assist in finding suitable options and work with properties to provide competitive prices and better service.',
  },
  {
    icon: 'social',
    eyebrow: 'Digital Presence',
    title: 'Social Media Promotion',
    description:
      'Hashtag Kerala provides promotional opportunities for hotels, resorts, restaurants, tourism businesses and brands looking to reach a relevant Kerala audience.',
  },
  {
    icon: 'map',
    eyebrow: 'Destination Focus',
    title: 'Kerala Destination Promotion',
    description:
      'We showcase destinations, experiences and hospitality businesses across Kerala, with a strong connection to Wayanad and its tourism ecosystem.',
  },
]

const collaborations = [
  'Social media promotions',
  'Hotel & resort promotions',
  'Destination promotions',
  'Brand collaborations',
  'Promotional campaigns',
  'Content creation',
  'Influencer marketing',
  'Tourism-related collaborations',
]
</script>

<template>
  <div class="space-y-20 pb-24">

    <!-- Hero -->
    <section
      class="relative h-[65svh] overflow-hidden rounded-[2.5rem] border border-white/50 bg-stone-950 px-5 text-white shadow-glass lg:px-10"
    >
      <div class="absolute inset-0 bg-stone-900">
        <div
          class="absolute inset-0 opacity-55 bg-[url('/assets/images/kerala_luxury_hotel.jpg')] bg-cover bg-center mix-blend-overlay"
        ></div>
        <div class="absolute inset-0 bg-gradient-to-br from-brand-primary/15 via-transparent to-stone-950/40"></div>
        <div class="absolute inset-x-0 bottom-0 h-1/2 bg-gradient-to-t from-stone-950 to-transparent"></div>
      </div>

      <div class="relative z-10 flex h-full flex-col items-center justify-center text-center py-12">
        <span class="eyebrow text-white/80">Our Story</span>
        <h1 class="mt-5 max-w-3xl font-heading text-5xl leading-tight sm:text-7xl lg:text-8xl">
          {{ siteSettings.about_title || 'About Hashtag Kerala' }}
        </h1>
        <p class="mt-6 max-w-2xl text-base text-white/75 sm:text-lg">
          Discover Kerala. Stay Better. Experience More.
        </p>
      </div>
    </section>

    <!-- Mission overview -->
    <section class="mx-auto max-w-5xl px-5 lg:px-0">
      <div class="grid gap-12 lg:grid-cols-2 lg:items-center">
        <div class="space-y-6">
          <span class="eyebrow">Who We Are</span>
          <h2 class="font-heading text-4xl leading-tight text-stone-900 dark:text-white">
            More Than Just a Travel Platform
          </h2>
          <p class="text-lg leading-relaxed text-stone-600 dark:text-stone-300">
            {{ siteSettings.about_content || 'Hashtag Kerala is built around two connected strengths — digital influence and hospitality discovery.' }}
          </p>
          <p class="text-base leading-relaxed text-stone-600 dark:text-stone-300">
            Through our website, visitors can explore hotels and stays across Kerala, organised
            <em>district by district</em>, making it easier to find the right accommodation for
            their trip. Customers can also send an enquiry through Hashtag Kerala — our team helps
            connect them with suitable properties and works towards providing competitive pricing,
            personalised assistance and a smooth booking experience.
          </p>
        </div>

        <!-- Stats grid -->
        <div class="grid grid-cols-2 gap-4">
          <div class="surface-glass rounded-[1.75rem] p-6 space-y-2">
            <p class="font-heading text-4xl text-brand-primary">14</p>
            <p class="text-sm text-stone-600 dark:text-stone-400 leading-5">Districts covered<br>across Kerala</p>
          </div>
          <div class="surface-glass rounded-[1.75rem] p-6 space-y-2">
            <p class="font-heading text-4xl text-brand-primary">100+</p>
            <p class="text-sm text-stone-600 dark:text-stone-400 leading-5">Hotels, resorts &amp;<br>homestays listed</p>
          </div>
          <div class="surface-glass rounded-[1.75rem] p-6 space-y-2">
            <p class="font-heading text-4xl text-brand-primary">∞</p>
            <p class="text-sm text-stone-600 dark:text-stone-400 leading-5">Experiences<br>waiting to be found</p>
          </div>
          <div class="surface-glass rounded-[1.75rem] p-6 space-y-2">
            <p class="font-heading text-4xl text-brand-primary">1</p>
            <p class="text-sm text-stone-600 dark:text-stone-400 leading-5">Passionate team<br>behind it all</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Founder section -->
    <section class="mx-auto max-w-5xl px-5 lg:px-0">
      <div class="overflow-hidden rounded-[2.5rem] border border-white/60 bg-white/60 shadow-glass backdrop-blur-xl dark:border-white/10 dark:bg-white/6">
        <div class="grid lg:grid-cols-[0.9fr_1.1fr]">

          <!-- Photo column -->
          <div class="relative overflow-hidden min-h-[400px] lg:min-h-[480px]">
            <img
              :src="'/assets/images/abhijith-mohan.jpg'"
              alt="Abhijith Mohan — Founder, Hashtag Kerala"
              class="absolute inset-0 h-full w-full object-cover object-top"
            />
          </div>

          <!-- Content column -->
          <div class="flex flex-col justify-center space-y-6 p-8 sm:p-10 lg:p-12">
            <span class="eyebrow">The Person Behind Hashtag Kerala</span>
            <h2 class="font-heading text-4xl text-stone-900 dark:text-white">Abhijith Mohan</h2>
            <p class="text-sm font-semibold uppercase tracking-[0.22em] text-brand-primary">
              Social Media Influencer · Digital Creator · Hashtag Kerala
            </p>
            <p class="text-base leading-relaxed text-stone-600 dark:text-stone-300">
              Abhijith Mohan is a social media influencer with a particular focus on Kerala and its
              destinations, with <strong class="text-stone-800 dark:text-white">Wayanad</strong> being one of his key areas of interest and activity.
            </p>
            <p class="text-base leading-relaxed text-stone-600 dark:text-stone-300">
              Through social media, he connects destinations, hospitality businesses and experiences
              with an audience interested in discovering what Kerala has to offer. His work combines
              content creation, destination promotion, hospitality marketing and social media
              influence — helping businesses reach potential customers while helping audiences
              discover new places and experiences.
            </p>

            <!-- Social links -->
            <div class="flex flex-wrap gap-3 pt-2">
              <a
                :href="socialLinks.instagram"
                target="_blank"
                rel="noopener noreferrer"
                class="inline-flex items-center gap-2 rounded-xl border border-stone-200/80 bg-white/80 px-4 py-2.5 text-sm font-medium text-stone-700 shadow-sm transition hover:-translate-y-0.5 hover:border-pink-300 hover:text-pink-600 dark:border-white/10 dark:bg-white/6 dark:text-stone-300 dark:hover:text-pink-400"
                aria-label="Instagram"
              >
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                  <rect x="3.5" y="3.5" width="17" height="17" rx="5"></rect>
                  <circle cx="12" cy="12" r="4"></circle>
                  <circle cx="17.5" cy="6.5" r="0.9" fill="currentColor" stroke="none"></circle>
                </svg>
                Instagram
              </a>
              <a
                :href="socialLinks.facebook"
                target="_blank"
                rel="noopener noreferrer"
                class="inline-flex items-center gap-2 rounded-xl border border-stone-200/80 bg-white/80 px-4 py-2.5 text-sm font-medium text-stone-700 shadow-sm transition hover:-translate-y-0.5 hover:border-blue-300 hover:text-blue-700 dark:border-white/10 dark:bg-white/6 dark:text-stone-300 dark:hover:text-blue-400"
                aria-label="Facebook"
              >
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M13.5 21v-7h2.4l.4-2.8h-2.8V9.4c0-.8.3-1.4 1.5-1.4h1.4V5.6c-.2 0-.9-.1-1.8-.1-1.8 0-3.1 1.1-3.1 3.2v2.5H9v2.8h2.5v7h2z"/>
                </svg>
                Facebook
              </a>
              <a
                :href="socialLinks.youtube"
                target="_blank"
                rel="noopener noreferrer"
                class="inline-flex items-center gap-2 rounded-xl border border-stone-200/80 bg-white/80 px-4 py-2.5 text-sm font-medium text-stone-700 shadow-sm transition hover:-translate-y-0.5 hover:border-red-300 hover:text-red-600 dark:border-white/10 dark:bg-white/6 dark:text-stone-300 dark:hover:text-red-400"
                aria-label="YouTube"
              >
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M21.6 7.2s-.2-1.4-.8-2c-.8-.8-1.6-.8-2-.9C16.4 4.1 12 4.1 12 4.1s-4.4 0-6.8.2c-.4.1-1.2.1-2 .9-.6.6-.8 2-.8 2S2.2 8.7 2.2 10.2v1.5c0 1.5.2 3 .2 3s.2 1.4.8 2c.8.8 1.8.8 2.3.9C7 17.8 12 17.9 12 17.9s4.4 0 6.8-.3c.4-.1 1.2-.1 2-.9.6-.6.8-2 .8-2s.2-1.5.2-3v-1.5c0-1.5-.2-3-.2-3zM9.9 14.1V9.5l5.4 2.3-5.4 2.3z"/>
                </svg>
                YouTube
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- What We Do -->
    <section class="mx-auto max-w-5xl space-y-10 px-5 lg:px-0">
      <div class="space-y-3 text-center">
        <span class="eyebrow">What We Do</span>
        <h2 class="section-heading">Four pillars of Hashtag Kerala</h2>
        <p class="mx-auto max-w-2xl text-sm leading-7 text-stone-600 dark:text-stone-400">
          From finding your perfect stay to promoting your business — here's how we connect Kerala's hospitality with the people who love it.
        </p>
      </div>

      <div class="grid gap-5 sm:grid-cols-2">
        <article
          v-for="(service, idx) in services"
          :key="idx"
          class="group surface-glass rounded-[1.75rem] p-7 transition duration-300 hover:-translate-y-1 hover:shadow-glass-lg"
        >
          <!-- Icon -->
          <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-2xl bg-brand-primary/12 text-brand-primary dark:bg-brand-primary/15">
            <svg v-if="service.icon === 'hotel'" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
              <polyline stroke-linecap="round" stroke-linejoin="round" points="9 22 9 12 15 12 15 22"/>
            </svg>
            <svg v-if="service.icon === 'enquiry'" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            <svg v-if="service.icon === 'social'" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
              <circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/>
              <line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/>
            </svg>
            <svg v-if="service.icon === 'map'" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
              <polygon stroke-linecap="round" stroke-linejoin="round" points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"/>
              <line stroke-linecap="round" stroke-linejoin="round" x1="8" y1="2" x2="8" y2="18"/>
              <line stroke-linecap="round" stroke-linejoin="round" x1="16" y1="6" x2="16" y2="22"/>
            </svg>
          </div>

          <span class="eyebrow text-[10px]">{{ service.eyebrow }}</span>
          <h3 class="mt-3 font-heading text-2xl text-stone-900 dark:text-white">{{ service.title }}</h3>
          <p class="mt-3 text-sm leading-7 text-stone-600 dark:text-stone-400">{{ service.description }}</p>
        </article>
      </div>
    </section>

    <!-- For Businesses -->
    <section class="mx-auto max-w-5xl px-5 lg:px-0">
      <div
        class="overflow-hidden rounded-[2.5rem] text-white"
        style="background: linear-gradient(135deg, #1a1a1a 0%, #2d1a00 60%, #1a1a1a 100%)"
      >
        <div class="h-1 w-full bg-gradient-to-r from-brand-primary via-amber-400 to-brand-primary"></div>

        <div class="grid gap-12 p-8 sm:p-12 lg:grid-cols-[1fr_0.9fr] lg:items-center">
          <div class="space-y-6">
            <span class="inline-flex items-center rounded-full border border-brand-primary/40 bg-brand-primary/20 px-4 py-1.5 text-xs font-semibold uppercase tracking-[0.28em] text-brand-primary">For Hotels &amp; Businesses</span>
            <h2 class="font-heading text-4xl leading-tight text-white">
              Grow your reach with Hashtag Kerala
            </h2>
            <p class="text-base leading-relaxed text-white/75">
              Are you a hotel, resort, homestay, restaurant, tourism business or local brand looking
              to reach more customers? Hashtag Kerala can help you gain visibility through our
              digital platforms and promotional activities.
            </p>
            <p class="text-base leading-relaxed text-white/75">
              Businesses can collaborate with <strong class="text-brand-primary">Abhijith Mohan / Hashtag Kerala</strong> for a range of
              promotional and content services tailored to Kerala's tourism audience.
            </p>
            <RouterLink :to="{ name: 'contact' }" class="btn-primary w-fit">
              Get in Touch
            </RouterLink>
          </div>

          <div class="grid grid-cols-2 gap-3">
            <div
              v-for="item in collaborations"
              :key="item"
              class="flex items-center gap-2 rounded-2xl border border-white/10 bg-white/6 px-4 py-3 text-sm text-white/80 backdrop-blur-sm"
            >
              <span class="h-1.5 w-1.5 shrink-0 rounded-full bg-brand-primary"></span>
              {{ item }}
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Mission & Vision -->
    <section class="mx-auto max-w-5xl space-y-8 px-5 lg:px-0">
      <div class="space-y-3 text-center">
        <span class="eyebrow">Our Vision</span>
        <h2 class="section-heading">Building Kerala's trusted travel platform</h2>
      </div>

      <div class="grid gap-6 md:grid-cols-2">
        <div class="surface-glass rounded-[1.75rem] p-8 space-y-4">
          <h3 class="font-heading text-2xl text-brand-primary">Our Mission</h3>
          <p class="text-sm leading-7 text-stone-600 dark:text-stone-400">
            {{ siteSettings.about_mission || 'To make discovering and experiencing Kerala easier, more accessible and more valuable for everyone — from peaceful hill stations and scenic resorts to hotels, homestays and unique stays across the state.' }}
          </p>
        </div>
        <div class="surface-glass rounded-[1.75rem] p-8 space-y-4">
          <h3 class="font-heading text-2xl text-brand-primary">Our Vision</h3>
          <p class="text-sm leading-7 text-stone-600 dark:text-stone-400">
            {{ siteSettings.about_vision || "To build Hashtag Kerala into a trusted digital destination for discovering the best places to stay, visit and experience across Kerala — benefiting both travellers and Kerala's hospitality and tourism businesses." }}
          </p>
        </div>
      </div>
    </section>

    <!-- Social CTA -->
    <section class="mx-auto max-w-5xl px-5 lg:px-0">
      <div class="relative overflow-hidden rounded-[2rem] p-1 bg-gradient-to-br from-brand-primary/20 via-amber-50 to-brand-primary/5 dark:from-brand-primary/15 dark:via-stone-900 dark:to-stone-950">
        <div class="rounded-[calc(2rem-4px)] bg-white/80 p-10 text-center backdrop-blur-xl dark:bg-stone-950/80">
          <span class="eyebrow">Follow Along</span>
          <h2 class="mt-5 font-heading text-3xl text-stone-900 dark:text-white">
            Discover Kerala with Hashtag Kerala
          </h2>
          <p class="mx-auto mt-4 max-w-xl text-stone-600 dark:text-stone-400">
            Find your stay. Discover new places. Experience Kerala. Follow us on social media for
            daily inspirations from every corner of God's Own Country.
          </p>
          <div class="mt-8 flex flex-wrap justify-center gap-4">
            <a
              :href="socialLinks.instagram"
              target="_blank"
              rel="noopener noreferrer"
              id="about-instagram-btn"
              class="btn-primary inline-flex items-center gap-2"
            >
              <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <rect x="3.5" y="3.5" width="17" height="17" rx="5"></rect>
                <circle cx="12" cy="12" r="4"></circle>
                <circle cx="17.5" cy="6.5" r="0.9" fill="currentColor" stroke="none"></circle>
              </svg>
              Instagram
            </a>
            <a
              :href="socialLinks.youtube"
              target="_blank"
              rel="noopener noreferrer"
              id="about-youtube-btn"
              class="btn-outline inline-flex items-center gap-2"
            >
              <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor">
                <path d="M21.6 7.2s-.2-1.4-.8-2c-.8-.8-1.6-.8-2-.9C16.4 4.1 12 4.1 12 4.1s-4.4 0-6.8.2c-.4.1-1.2.1-2 .9-.6.6-.8 2-.8 2S2.2 8.7 2.2 10.2v1.5c0 1.5.2 3 .2 3s.2 1.4.8 2c.8.8 1.8.8 2.3.9C7 17.8 12 17.9 12 17.9s4.4 0 6.8-.3c.4-.1 1.2-.1 2-.9.6-.6.8-2 .8-2s.2-1.5.2-3v-1.5c0-1.5-.2-3-.2-3zM9.9 14.1V9.5l5.4 2.3-5.4 2.3z"/>
              </svg>
              YouTube
            </a>
            <a
              :href="socialLinks.facebook"
              target="_blank"
              rel="noopener noreferrer"
              id="about-facebook-btn"
              class="btn-outline inline-flex items-center gap-2"
            >
              <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor">
                <path d="M13.5 21v-7h2.4l.4-2.8h-2.8V9.4c0-.8.3-1.4 1.5-1.4h1.4V5.6c-.2 0-.9-.1-1.8-.1-1.8 0-3.1 1.1-3.1 3.2v2.5H9v2.8h2.5v7h2z"/>
              </svg>
              Facebook
            </a>
          </div>
        </div>
      </div>
    </section>

  </div>
</template>
