<script setup>
import { computed, onBeforeUnmount, onMounted, ref } from 'vue'
import { storeToRefs } from 'pinia'
import { useAppStore } from '../stores/app'
import logoLight from '../assets/logo-light.png'
import logoDark from '../assets/logo-dark.png'

const appStore = useAppStore()
const { isDark } = storeToRefs(appStore)

const logo = computed(() => (isDark.value ? logoDark : logoLight))

const isMenuOpen = ref(false)
const isScrolled = ref(false)

const links = [
  { name: 'Home', to: { name: 'home' } },
  { name: 'About', to: { name: 'about' } },
  { name: 'Kerala Tourism', to: { name: 'tourism' } },
  { name: 'Tourism News', to: { name: 'news' } },
  { name: 'Contact', to: { name: 'contact' } },
]

const themeLabel = computed(() => (isDark.value ? 'Light mode' : 'Dark mode'))

const updateScrollState = () => {
  isScrolled.value = window.scrollY > 16
}

const closeMenu = () => {
  isMenuOpen.value = false
}

const toggleMenu = () => {
  isMenuOpen.value = !isMenuOpen.value
}

onMounted(() => {
  updateScrollState()
  window.addEventListener('scroll', updateScrollState, { passive: true })
})

onBeforeUnmount(() => {
  window.removeEventListener('scroll', updateScrollState)
})
</script>

<template>
  <header
    class="nav-shell"
    :class="{ 'nav-shell-scrolled': isScrolled }"
  >
    <div class="shell-container flex h-16 items-center justify-between gap-4">
      <RouterLink to="/" class="flex items-center">
        <img :src="logo" alt="Hashtag Kerala" class="h-14 w-auto drop-shadow-sm" />
      </RouterLink>

      <nav class="hidden items-center gap-1 lg:flex">
        <RouterLink
          v-for="link in links"
          :key="link.name"
          :to="link.to"
          class="rounded-full px-4 py-2 text-sm font-medium text-stone-600 transition hover:bg-white/70 hover:text-brand-secondary dark:text-stone-300 dark:hover:bg-white/6 dark:hover:text-white"
        >
          {{ link.name }}
        </RouterLink>
      </nav>

      <div class="flex items-center gap-2">
        <button
          type="button"
          class="btn-ghost hidden h-11 w-11 rounded-full p-0 sm:inline-flex"
          aria-label="Search"
        >
          <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8">
            <circle cx="11" cy="11" r="6"></circle>
            <path d="M20 20l-4.2-4.2"></path>
          </svg>
        </button>

        <button
          type="button"
          class="btn-ghost hidden h-11 w-11 p-0 items-center justify-center rounded-full lg:inline-flex"
          aria-label="Toggle theme"
          @click="appStore.toggleTheme"
        >
          <svg v-if="!isDark" viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8">
            <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
          </svg>
          <svg v-else viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8">
            <circle cx="12" cy="12" r="5"></circle>
            <path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"></path>
          </svg>
        </button>

        <RouterLink :to="{ name: 'contact' }" class="btn-primary hidden sm:inline-flex">
          Contact
        </RouterLink>

        <button
          type="button"
          class="inline-flex h-11 w-11 items-center justify-center rounded-full border border-brand-line/70 bg-white/70 text-brand-ink shadow-sm backdrop-blur-xs lg:hidden dark:border-white/10 dark:bg-white/6 dark:text-white"
          :aria-expanded="isMenuOpen"
          aria-label="Toggle menu"
          @click="toggleMenu"
        >
          <svg v-if="!isMenuOpen" viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8">
            <path d="M4 7h16"></path>
            <path d="M4 12h16"></path>
            <path d="M4 17h16"></path>
          </svg>
          <svg v-else viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8">
            <path d="M6 6l12 12"></path>
            <path d="M18 6L6 18"></path>
          </svg>
        </button>
      </div>
    </div>

    <Transition name="overlay">
      <div
        v-if="isMenuOpen"
        class="fixed inset-0 z-40 bg-brand-ink/70 backdrop-blur-md lg:hidden"
      >
        <div class="overlay-panel flex min-h-screen flex-col bg-brand-surface px-6 py-6 transition duration-300 dark:bg-stone-950">
          <div class="flex items-center justify-between">
            <RouterLink to="/" class="flex items-center" @click="closeMenu">
              <img :src="logo" alt="Hashtag Kerala" class="h-14 w-auto drop-shadow-sm" />
            </RouterLink>

            <button
              type="button"
              class="inline-flex h-11 w-11 items-center justify-center rounded-full border border-brand-line/70 bg-white/70 text-brand-ink shadow-sm dark:border-white/10 dark:bg-white/6 dark:text-white"
              aria-label="Close menu"
              @click="closeMenu"
            >
              <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8">
                <path d="M6 6l12 12"></path>
                <path d="M18 6L6 18"></path>
              </svg>
            </button>
          </div>

          <div class="mt-12 flex flex-1 flex-col justify-between">
            <nav class="flex flex-col gap-3">
              <RouterLink
                v-for="link in links"
                :key="link.name"
                :to="link.to"
                class="rounded-3xl border border-brand-line/70 bg-white/70 px-5 py-4 font-heading text-3xl text-brand-ink shadow-sm backdrop-blur-xs dark:border-white/10 dark:bg-white/6 dark:text-white"
                @click="closeMenu"
              >
                {{ link.name }}
              </RouterLink>
            </nav>

            <div class="space-y-4 pt-10">
              <div class="flex items-center gap-3">
                <button type="button" class="btn-ghost h-12 w-12 rounded-full p-0" aria-label="Search">
                  <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8">
                    <circle cx="11" cy="11" r="6"></circle>
                    <path d="M20 20l-4.2-4.2"></path>
                  </svg>
                </button>
                <button type="button" class="btn-ghost h-12 w-12 rounded-full p-0 flex items-center justify-center" aria-label="Toggle theme" @click="appStore.toggleTheme">
                  <svg v-if="!isDark" viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                  </svg>
                  <svg v-else viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8">
                    <circle cx="12" cy="12" r="5"></circle>
                    <path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"></path>
                  </svg>
                </button>
              </div>

              <RouterLink :to="{ name: 'contact' }" class="btn-primary w-full text-center" @click="closeMenu">
                Contact
              </RouterLink>
            </div>
          </div>
        </div>
      </div>
    </Transition>
  </header>
</template>
