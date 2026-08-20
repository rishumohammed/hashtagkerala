<script setup>
import { computed } from 'vue'
import { storeToRefs } from 'pinia'
import { useAppStore } from '../stores/app'
import logoLight from '../assets/logo-light.png'
import logoDark from '../assets/logo-dark.png'

const appStore = useAppStore()
const { isDark } = storeToRefs(appStore)

const logo = computed(() => (isDark.value ? logoDark : logoLight))
</script>

<template>
  <footer class="footer-shell">
    <div class="shell-container grid gap-10 py-16 md:grid-cols-[1.15fr_0.8fr_0.9fr]">
      <div class="space-y-6">
        <img :src="logo" alt="Hashtag Kerala" class="h-14 w-auto drop-shadow-sm" />
        <p class="max-w-sm text-sm leading-7 text-stone-600 dark:text-stone-400">
          Kerala-inspired travel experiences with a calm, premium interface for curated stays, districts, and coastal escapes.
        </p>
        <div class="flex gap-2">
          <a href="#" class="btn-ghost h-10 w-10 rounded-full p-0" aria-label="Instagram">
            <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8">
              <rect x="3.5" y="3.5" width="17" height="17" rx="5"></rect>
              <circle cx="12" cy="12" r="4"></circle>
              <circle cx="17.5" cy="6.5" r="0.9" fill="currentColor" stroke="none"></circle>
            </svg>
          </a>
          <a href="#" class="btn-ghost h-10 w-10 rounded-full p-0" aria-label="Facebook">
            <svg viewBox="0 0 24 24" class="h-4 w-4" fill="currentColor">
              <path d="M13.5 21v-7h2.4l.4-2.8h-2.8V9.4c0-.8.3-1.4 1.5-1.4h1.4V5.6c-.2 0-.9-.1-1.8-.1-1.8 0-3.1 1.1-3.1 3.2v2.5H9v2.8h2.5v7h2z"></path>
            </svg>
          </a>
          <a href="#" class="btn-ghost h-10 w-10 rounded-full p-0" aria-label="X">
            <svg viewBox="0 0 24 24" class="h-4 w-4" fill="currentColor">
              <path d="M17.2 4H20l-6.1 7 7.1 9h-5.6L11 14.4 6.2 20H3.4l6.5-7.5L3 4h5.7l4 5.1L17.2 4z"></path>
            </svg>
          </a>
        </div>
      </div>

      <div class="space-y-4">
        <p class="text-sm font-semibold uppercase tracking-[0.22em] text-stone-500 dark:text-stone-400">Quick links</p>
        <div class="flex flex-col gap-3 text-sm text-stone-600 dark:text-stone-400">
          <a href="#home" class="hover:text-brand-primary dark:hover:text-white">Home</a>
          <a href="#districts" class="hover:text-brand-primary dark:hover:text-white">Districts</a>
          <a href="#explore" class="hover:text-brand-primary dark:hover:text-white">Explore</a>
        </div>
      </div>

      <div class="space-y-4">
        <p class="text-sm font-semibold uppercase tracking-[0.22em] text-stone-500 dark:text-stone-400">Contact</p>
        <div class="space-y-3 text-sm leading-6 text-stone-600 dark:text-stone-400">
          <p>About: Premium, minimal travel inspiration rooted in Kerala's districts and landscapes.</p>
          <p>Hashtaggroup9229@gmail.com</p>
          <p>+91 99611 99229</p>
          <p>Wayanad, Kerala, India</p>
        </div>
      </div>
    </div>

    <div class="shell-container border-t border-white/60 py-5 text-sm text-stone-500 dark:border-white/8 dark:text-stone-400">
      <p>&copy; 2026 Hashtag Kerala. All rights reserved.</p>
    </div>
  </footer>
</template>
