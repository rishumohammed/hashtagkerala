import { computed, ref } from 'vue'
import { defineStore } from 'pinia'
import { getStoredTheme, setStoredTheme } from '../services/theme'

export const useAppStore = defineStore('app', () => {
  const theme = ref(getStoredTheme())

  const isDark = computed(() => theme.value === 'dark')

  const setTheme = (value) => {
    theme.value = value
    setStoredTheme(value)
  }

  const toggleTheme = () => {
    setTheme(isDark.value ? 'light' : 'dark')
  }

  return {
    isDark,
    theme,
    setTheme,
    toggleTheme,
  }
})
