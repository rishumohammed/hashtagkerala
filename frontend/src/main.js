import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import { createPinia } from 'pinia'
import '@fontsource/inter'
import '@fontsource/playfair-display'
import './assets/styles/main.css'
import { createHead } from '@unhead/vue/client'
import { initializeTheme } from './services/theme'

initializeTheme()

const app = createApp(App)
const head = createHead()

app.use(createPinia())
app.use(router)
app.use(head)

app.mount('#app')
