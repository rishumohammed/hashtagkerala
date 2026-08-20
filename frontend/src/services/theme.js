const THEME_KEY = 'hashtag-kerala-theme'

const applyTheme = (theme) => {
  document.documentElement.classList.toggle('dark', theme === 'dark')
}

export const getPreferredTheme = () => {
  if (typeof window === 'undefined') {
    return 'light'
  }

  return window.matchMedia('(prefers-color-scheme: dark)').matches
    ? 'dark'
    : 'light'
}

export const getStoredTheme = () => {
  if (typeof window === 'undefined') {
    return 'light'
  }

  return localStorage.getItem(THEME_KEY) || getPreferredTheme()
}

export const setStoredTheme = (theme) => {
  if (typeof window === 'undefined') {
    return
  }

  localStorage.setItem(THEME_KEY, theme)
  applyTheme(theme)
}

export const initializeTheme = () => {
  applyTheme(getStoredTheme())
}
