<script setup>
import { onMounted, ref } from 'vue'
import { useHead } from '@unhead/vue'
import { apiClient } from '../services/api'

const form = ref({
  name: '',
  email: '',
  phone: '',
  subject: '',
  message: ''
})

const siteSettings = ref({})
const isSubmitting = ref(false)
const statusMessage = ref('')
const isSuccess = ref(false)

onMounted(async () => {
  try {
    const res = await apiClient.get('/settings')
    siteSettings.value = res.data || {}
  } catch (e) {
    console.error('Failed to load settings:', e)
  }
})

const handleSubmit = async () => {
  isSubmitting.value = true
  statusMessage.value = ''
  
  try {
    const res = await apiClient.post('/contact', form.value)
    isSuccess.value = true
    statusMessage.value = res.data?.message || 'Thank you! Your message has been sent.'
    form.value = { name: '', email: '', phone: '', subject: '', message: '' }
  } catch (e) {
    isSuccess.value = false
    const errData = e.response?.data
    statusMessage.value = errData?.errors 
      ? Object.values(errData.errors).flat().join(' ') 
      : (errData?.message || 'Something went wrong. Please try again.')
  } finally {
    isSubmitting.value = false
  }
}

useHead({
  title: 'Contact Us | Hashtag Kerala',
  meta: [
    { name: 'description', content: 'Get in touch with the Hashtag Kerala team for inquiries, partnerships, or travel assistance.' }
  ]
})
</script>

<template>
  <div class="space-y-24 pb-20">
    <section class="relative h-[50svh] overflow-hidden rounded-[2.5rem] bg-stone-900 border border-white/20 shadow-glass flex items-center justify-center text-center px-5">
       <div class="absolute inset-0 bg-[url('/assets/images/kerala_beach.jpg')] bg-cover bg-center brightness-[0.6]"></div>
       <div class="relative z-10 space-y-4">
          <span class="eyebrow text-white/80">Get in Touch</span>
          <h1 class="font-heading text-6xl text-white">Contact Us</h1>
       </div>
    </section>

    <section class="mx-auto max-w-7xl px-5 lg:px-10">
      <div class="grid gap-16 lg:grid-cols-2">
         <!-- Contact Info -->
         <div class="space-y-12">
            <div class="space-y-6">
               <h2 class="font-heading text-4xl dark:text-white">We'd love to hear from you.</h2>
               <p class="text-lg leading-relaxed text-stone-600 dark:text-stone-400">
                  Whether you have a question about a stay, want to partner with us, or simply want to share your Kerala travel story, our team is ready to connect.
               </p>
            </div>

            <div class="space-y-8">
               <!-- Email -->
               <div class="flex items-start gap-6">
                  <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-brand-secondary/10 text-brand-secondary dark:bg-brand-secondary/5">
                     <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                  </div>
                  <div class="space-y-1">
                     <p class="text-sm font-semibold uppercase tracking-widest text-stone-500">Email Address</p>
                     <p class="text-xl dark:text-white">{{ siteSettings.contact_email || 'Hashtaggroup9229@gmail.com' }}</p>
                  </div>
               </div>

               <!-- Phone -->
               <div class="flex items-start gap-6">
                  <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-brand-secondary/10 text-brand-secondary dark:bg-brand-secondary/5">
                     <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                  </div>
                  <div class="space-y-1">
                     <p class="text-sm font-semibold uppercase tracking-widest text-stone-500">Contact Number</p>
                     <p class="text-xl dark:text-white">{{ siteSettings.contact_phone || '+91 99611 99229' }}</p>
                  </div>
               </div>

               <!-- Location -->
               <div class="flex items-start gap-6">
                  <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-brand-secondary/10 text-brand-secondary dark:bg-brand-secondary/5">
                     <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                  </div>
                  <div class="space-y-1">
                     <p class="text-sm font-semibold uppercase tracking-widest text-stone-500">Our Location</p>
                     <p class="text-xl dark:text-white">{{ siteSettings.contact_address || 'Wayanad, India, Kerala' }}</p>
                  </div>
               </div>
            </div>
         </div>

         <!-- Contact Form -->
         <div class="surface-glass rounded-[2.5rem] p-8 sm:p-12">
            <form @submit.prevent="handleSubmit" class="space-y-6">
               <div class="grid gap-6 sm:grid-cols-2">
                  <div class="space-y-2">
                     <label class="text-xs font-semibold uppercase tracking-widest text-stone-500">Your Name</label>
                     <input v-model="form.name" type="text" required class="input-field" placeholder="John Doe" />
                  </div>
                  <div class="space-y-2">
                     <label class="text-xs font-semibold uppercase tracking-widest text-stone-500">Email Address</label>
                     <input v-model="form.email" type="email" required class="input-field" placeholder="john@example.com" />
                  </div>
               </div>
               <div class="grid gap-6 sm:grid-cols-2">
                  <div class="space-y-2">
                     <label class="text-xs font-semibold uppercase tracking-widest text-stone-500">Phone Number</label>
                     <input v-model="form.phone" type="tel" required class="input-field" placeholder="+91 98765 43210" />
                  </div>
                  <div class="space-y-2">
                     <label class="text-xs font-semibold uppercase tracking-widest text-stone-500">Subject</label>
                     <input v-model="form.subject" type="text" class="input-field" placeholder="Inquiry about..." />
                  </div>
               </div>
               <div class="space-y-2">
                  <label class="text-xs font-semibold uppercase tracking-widest text-stone-500">Your Message</label>
                  <textarea v-model="form.message" required rows="5" class="input-field resize-none pt-4" placeholder="How can we help you?"></textarea>
               </div>
               
               <button 
                  type="submit" 
                  class="btn-primary w-full h-[60px]"
                  :disabled="isSubmitting"
               >
                  <span v-if="isSubmitting">Sending...</span>
                  <span v-else>Send Message</span>
               </button>

               <p v-if="statusMessage" class="text-center text-sm mt-4" :class="isSuccess ? 'text-emerald-500' : 'text-rose-500'">
                  {{ statusMessage }}
               </p>
            </form>
         </div>
      </div>
    </section>
  </div>
</template>
