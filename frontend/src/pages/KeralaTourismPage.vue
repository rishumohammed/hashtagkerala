<script setup>
import { useHead } from '@unhead/vue'

const tourismHighlights = [
  {
    category: 'Misty Mountains',
    title: 'Munnar & Wayanad',
    image: '/assets/images/kerala_tea_hills.jpg',
    description: 'Vast tea plantations, rolling emerald hills, majestic waterfalls, and cool mountain air that refreshes the soul.'
  },
  {
    category: 'Coastal Dreams',
    title: 'Alleppey & Marari',
    image: '/assets/images/kerala_backwaters.jpg',
    description: 'The iconic backwaters of Kerala, where life moves at a peaceful pace along palm-fringed canals.'
  },
  {
    category: 'Heritage Soul',
    title: 'Kochi & Trivandrum',
    image: '/assets/images/kerala_heritage.jpg',
    description: 'A blend of colonial history, ancient spice trade networks, vibrant art districts, and rich cultural traditions.'
  }
]

useHead({
  title: 'Kerala Tourism Guide | Discover God\'s Own Country | Hashtag Kerala',
  meta: [
    { name: 'description', content: 'Explore the complete travel guide to Kerala. Discover the best destinations, local cuisine, classical performing arts, ancient history, and Ayurvedic wellness.' }
  ]
})
</script>

<template>
  <div class="space-y-28 pb-24">
    <!-- Hero Section -->
    <section class="relative min-h-[85svh] overflow-hidden rounded-[2.5rem] bg-stone-900 border border-white/20 shadow-glass flex flex-col items-center justify-center text-center px-5 py-16 lg:px-10">
      <div class="absolute inset-0 bg-[url('/assets/images/kerala_backwaters.jpg')] bg-cover bg-center brightness-[0.55]"></div>
      <div class="absolute inset-0 bg-gradient-to-b from-transparent via-stone-950/20 to-stone-950/70"></div>

      <div class="relative z-10 mx-auto max-w-5xl space-y-8">
        <span class="inline-flex items-center rounded-full border border-brand-primary/40 bg-brand-primary/20 px-4 py-1.5 text-xs font-semibold uppercase tracking-[0.28em] text-brand-primary">
          Discover The Soul
        </span>
        <h1 class="font-heading text-6xl leading-[1.1] text-white sm:text-7xl lg:text-9xl">
          Kerala <br /> Tourism
        </h1>
        <p class="mx-auto max-w-2xl text-base leading-relaxed text-white/90 sm:text-lg">
          Experience the extraordinary diversity of landscapes, cultures, and traditions that make Kerala "God's Own Country."
        </p>
      </div>
    </section>

    <!-- Signature Experiences -->
    <section class="space-y-16 px-5 lg:px-10">
      <div class="text-center space-y-4">
        <span class="inline-flex items-center rounded-full border border-brand-primary/40 bg-brand-primary/25 px-4 py-1 text-xs font-semibold uppercase tracking-[0.22em] text-brand-primary">
          Icons of Kerala
        </span>
        <h2 class="font-heading text-4xl text-brand-ink sm:text-5xl lg:text-6xl dark:text-white">
          Signature Experiences
        </h2>
        <p class="mx-auto max-w-2xl text-stone-600 dark:text-stone-400">
          Curated themes for those who seek more than just a destination.
        </p>
      </div>

      <div class="grid gap-10 md:grid-cols-2 lg:grid-cols-3">
        <div 
          v-for="item in tourismHighlights" 
          :key="item.title"
          class="group space-y-6"
        >
          <div class="aspect-[4/5] overflow-hidden rounded-[2.5rem] border border-white/20 shadow-glass">
            <img 
              :src="item.image" 
              :alt="item.title" 
              class="h-full w-full object-cover transition duration-700 group-hover:scale-110" 
            />
          </div>
          <div class="space-y-3 px-2 text-center">
            <span class="text-xs font-semibold uppercase tracking-[0.22em] text-brand-primary">{{ item.category }}</span>
            <h3 class="font-heading text-2xl text-stone-900 dark:text-white">{{ item.title }}</h3>
            <p class="text-sm leading-relaxed text-stone-600 dark:text-stone-400">{{ item.description }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Regional Travel Guide -->
    <section class="space-y-16 px-5 lg:px-10">
      <div class="text-center space-y-4">
        <span class="inline-flex items-center rounded-full border border-brand-primary/40 bg-brand-primary/25 px-4 py-1 text-xs font-semibold uppercase tracking-[0.22em] text-brand-primary">
          Regional Blueprint
        </span>
        <h2 class="font-heading text-4xl text-brand-ink sm:text-5xl lg:text-6xl dark:text-white">
          Destinations Across Kerala
        </h2>
        <p class="mx-auto max-w-2xl text-stone-600 dark:text-stone-400">
          From the quiet hills of the north to the lively beaches of the south, plan your journey across regions.
        </p>
      </div>

      <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
        <!-- North Kerala -->
        <div class="surface-glass rounded-[2.5rem] overflow-hidden border border-white/60 dark:border-white/10 flex flex-col justify-between group">
          <div class="aspect-video overflow-hidden">
            <img 
              src="/assets/images/kerala_region_north.jpg" 
              alt="North Kerala - Bekal Fort" 
              class="w-full h-full object-cover transition duration-500 group-hover:scale-105" 
            />
          </div>
          <div class="p-8 sm:p-10 space-y-6 flex-1 flex flex-col justify-between">
            <div class="space-y-4">
              <span class="text-xs font-bold uppercase tracking-widest text-brand-secondary">The Malabar Realm</span>
              <h3 class="font-heading text-3xl text-stone-900 dark:text-white">North Kerala</h3>
              <p class="text-sm leading-relaxed text-stone-600 dark:text-stone-400">
                Pristine, untouched, and rich in culinary heritage. North Kerala is ideal for off-beat travelers who love quiet beaches, ancient forests, and intense ritual performing arts.
              </p>
              <div class="pt-4 border-t border-brand-line dark:border-white/10 space-y-3">
                <p class="text-xs font-semibold uppercase tracking-wider text-stone-500">Key Districts</p>
                <div class="flex flex-wrap gap-2">
                  <span class="px-3 py-1 text-xs rounded-full bg-stone-100 dark:bg-white/5 text-stone-700 dark:text-stone-300">Wayanad</span>
                  <span class="px-3 py-1 text-xs rounded-full bg-stone-100 dark:bg-white/5 text-stone-700 dark:text-stone-300">Kozhikode</span>
                  <span class="px-3 py-1 text-xs rounded-full bg-stone-100 dark:bg-white/5 text-stone-700 dark:text-stone-300">Kannur</span>
                  <span class="px-3 py-1 text-xs rounded-full bg-stone-100 dark:bg-white/5 text-stone-700 dark:text-stone-300">Kasaragod</span>
                </div>
              </div>
            </div>
            <div class="space-y-2 pt-4">
              <p class="text-xs font-semibold uppercase tracking-wider text-stone-500">Must-Visit Attractions</p>
              <ul class="text-sm space-y-1 text-stone-700 dark:text-stone-300 list-disc list-inside">
                <li>Edakkal Caves & Banasura Hill</li>
                <li>Bekal Fort & Beach</li>
                <li>Muzhappilangad Drive-in Beach</li>
                <li>Theyyam ritual performances</li>
              </ul>
            </div>
          </div>
        </div>

        <!-- Central Kerala -->
        <div class="surface-glass rounded-[2.5rem] overflow-hidden border border-white/60 dark:border-white/10 flex flex-col justify-between group">
          <div class="aspect-video overflow-hidden">
            <img 
              src="/assets/images/kerala_region_central.jpg" 
              alt="Central Kerala - Athirappilly Waterfalls" 
              class="w-full h-full object-cover transition duration-500 group-hover:scale-105" 
            />
          </div>
          <div class="p-8 sm:p-10 space-y-6 flex-1 flex flex-col justify-between">
            <div class="space-y-4">
              <span class="text-xs font-bold uppercase tracking-widest text-brand-secondary">The Cultural Core</span>
              <h3 class="font-heading text-3xl text-stone-900 dark:text-white">Central Kerala</h3>
              <p class="text-sm leading-relaxed text-stone-600 dark:text-stone-400">
                Where historical trade ports meet misty mountain tea estates. A region bustling with heritage, colonial-era architecture, traditional festivals, and high-altitude retreats.
              </p>
              <div class="pt-4 border-t border-brand-line dark:border-white/10 space-y-3">
                <p class="text-xs font-semibold uppercase tracking-wider text-stone-500">Key Districts</p>
                <div class="flex flex-wrap gap-2">
                  <span class="px-3 py-1 text-xs rounded-full bg-stone-100 dark:bg-white/5 text-stone-700 dark:text-stone-300">Ernakulam (Kochi)</span>
                  <span class="px-3 py-1 text-xs rounded-full bg-stone-100 dark:bg-white/5 text-stone-700 dark:text-stone-300">Idukki (Munnar)</span>
                  <span class="px-3 py-1 text-xs rounded-full bg-stone-100 dark:bg-white/5 text-stone-700 dark:text-stone-300">Thrissur</span>
                  <span class="px-3 py-1 text-xs rounded-full bg-stone-100 dark:bg-white/5 text-stone-700 dark:text-stone-300">Palakkad</span>
                </div>
              </div>
            </div>
            <div class="space-y-2 pt-4">
              <p class="text-xs font-semibold uppercase tracking-wider text-stone-500">Must-Visit Attractions</p>
              <ul class="text-sm space-y-1 text-stone-700 dark:text-stone-300 list-disc list-inside">
                <li>Fort Kochi & Chinese Fishing Nets</li>
                <li>Munnar Tea Gardens & Eravikulam</li>
                <li>Athirappilly Waterfalls</li>
                <li>Thrissur Vadakkunnathan Temple</li>
              </ul>
            </div>
          </div>
        </div>

        <!-- South Kerala -->
        <div class="surface-glass rounded-[2.5rem] overflow-hidden border border-white/60 dark:border-white/10 flex flex-col justify-between group">
          <div class="aspect-video overflow-hidden">
            <img 
              src="/assets/images/kerala_region_south.jpg" 
              alt="South Kerala - Varkala Beach" 
              class="w-full h-full object-cover transition duration-500 group-hover:scale-105" 
            />
          </div>
          <div class="p-8 sm:p-10 space-y-6 flex-1 flex flex-col justify-between">
            <div class="space-y-4">
              <span class="text-xs font-bold uppercase tracking-widest text-brand-secondary">Serene Escapes</span>
              <h3 class="font-heading text-3xl text-stone-900 dark:text-white">South Kerala</h3>
              <p class="text-sm leading-relaxed text-stone-600 dark:text-stone-400">
                The cradle of backwaters, pristine coastal cliffs, and Ayurvedic rejuvenation. Ideal for slowing down on houseboats, relaxing on beaches, or experiencing temple festivals.
              </p>
              <div class="pt-4 border-t border-brand-line dark:border-white/10 space-y-3">
                <p class="text-xs font-semibold uppercase tracking-wider text-stone-500">Key Districts</p>
                <div class="flex flex-wrap gap-2">
                  <span class="px-3 py-1 text-xs rounded-full bg-stone-100 dark:bg-white/5 text-stone-700 dark:text-stone-300">Alappuzha</span>
                  <span class="px-3 py-1 text-xs rounded-full bg-stone-100 dark:bg-white/5 text-stone-700 dark:text-stone-300">Kottayam</span>
                  <span class="px-3 py-1 text-xs rounded-full bg-stone-100 dark:bg-white/5 text-stone-700 dark:text-stone-300">Kollam</span>
                  <span class="px-3 py-1 text-xs rounded-full bg-stone-100 dark:bg-white/5 text-stone-700 dark:text-stone-300">Trivandrum</span>
                </div>
              </div>
            </div>
            <div class="space-y-2 pt-4">
              <p class="text-xs font-semibold uppercase tracking-wider text-stone-500">Must-Visit Attractions</p>
              <ul class="text-sm space-y-1 text-stone-700 dark:text-stone-300 list-disc list-inside">
                <li>Alappuzha (Alleppey) Backwaters</li>
                <li>Varkala Cliff Beach & Temple</li>
                <li>Kovalam Lighthouse Beach</li>
                <li>Kumarakom Bird Sanctuary</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- History, Heritage & Classical Arts -->
    <section class="bg-stone-950 py-24 text-white rounded-[4rem] mx-2 border border-white/5 shadow-2xl">
      <div class="mx-auto max-w-6xl px-5 lg:px-10 space-y-20">
        <!-- Part 1: Ancient Spice Route & History -->
        <div class="grid gap-12 lg:grid-cols-2 lg:items-center">
          <div class="space-y-6">
            <span class="inline-flex items-center rounded-full border border-brand-primary/40 bg-brand-primary/20 px-4 py-1.5 text-xs font-semibold uppercase tracking-[0.22em] text-brand-primary">
              Muziris & Beyond
            </span>
            <h2 class="font-heading text-4xl leading-tight sm:text-5xl lg:text-6xl">
              The Gateway of Spices
            </h2>
            <p class="text-base leading-relaxed text-stone-300 sm:text-lg">
              For over 3,000 years, Kerala stood as the crown jewel of the global spice trade. Its hills produced the finest black pepper—referred to as "Black Gold"—along with cardamom, cinnamon, and ginger.
            </p>
            <p class="text-base leading-relaxed text-stone-300 sm:text-lg">
              The legendary port of Muziris drew Phoenicians, Egyptians, Romans, Greeks, Chinese, and Arabs. It was here that distinct cultures fused, giving birth to a diverse, syncretic heritage long before colonial ships reached its shores.
            </p>
          </div>
          <div class="relative">
            <div class="aspect-video lg:aspect-[4/3] rounded-[2.5rem] overflow-hidden border border-white/10 shadow-2xl">
              <img 
                src="/assets/images/kerala_heritage.jpg" 
                alt="Kerala Spice Route and Heritage" 
                class="h-full w-full object-cover" 
              />
            </div>
          </div>
        </div>

        <!-- Part 2: Classical Arts Grid -->
        <div class="space-y-12">
          <div class="space-y-4">
            <span class="text-xs font-bold uppercase tracking-widest text-brand-secondary">Living Heritage</span>
            <h3 class="font-heading text-3xl sm:text-4xl">Classical Performing Arts</h3>
            <p class="max-w-2xl text-sm text-stone-400">
              The visual poetry, complex rhythm, and devotion of Kerala's centuries-old traditional art forms.
            </p>
          </div>

          <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
            <!-- Kathakali -->
            <div class="bg-white/5 border border-white/10 rounded-[2rem] p-8 space-y-4 hover:bg-white/10 transition-all duration-300">
              <h4 class="font-heading text-2xl text-brand-primary">Kathakali</h4>
              <p class="text-sm leading-relaxed text-stone-300">
                A spectacular dance-drama characterized by extremely stylized makeup, vibrant costumes, complex mudras (hand gestures), and dramatic facial expressions depicting stories from Indian epics.
              </p>
            </div>

            <!-- Theyyam -->
            <div class="bg-white/5 border border-white/10 rounded-[2rem] p-8 space-y-4 hover:bg-white/10 transition-all duration-300">
              <h4 class="font-heading text-2xl text-brand-primary">Theyyam</h4>
              <p class="text-sm leading-relaxed text-stone-300">
                An ancient, dramatic ritual performance of North Kerala. Performers deck themselves in gigantic headdresses and red paint, channeling divine spirits through intense, fire-lit dances.
              </p>
            </div>

            <!-- Kalaripayattu -->
            <div class="bg-white/5 border border-white/10 rounded-[2rem] p-8 space-y-4 hover:bg-white/10 transition-all duration-300">
              <h4 class="font-heading text-2xl text-brand-primary">Kalaripayattu</h4>
              <p class="text-sm leading-relaxed text-stone-300">
                Widely regarded as the mother of all martial arts, Kalaripayattu combines fluid, animal-inspired defensive leaps with armed combat, utilizing traditional wooden and metal weaponry.
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Flavours of Kerala (Culinary Journey) -->
    <section class="space-y-16 px-5 lg:px-10">
      <div class="text-center space-y-4">
        <span class="inline-flex items-center rounded-full border border-brand-primary/40 bg-brand-primary/25 px-4 py-1 text-xs font-semibold uppercase tracking-[0.22em] text-brand-primary">
          Culinary Traditions
        </span>
        <h2 class="font-heading text-4xl text-brand-ink sm:text-5xl lg:text-6xl dark:text-white">
          Flavours of Kerala
        </h2>
        <p class="mx-auto max-w-2xl text-stone-600 dark:text-stone-400">
          A rich, aromatic cuisine characterized by coconut, curry leaves, fresh seafood, and direct spices.
        </p>
      </div>

      <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Kerala Sadhya -->
        <div class="surface-glass rounded-[2rem] overflow-hidden border border-white/60 dark:border-white/10 flex flex-col justify-between group">
          <div class="aspect-video overflow-hidden">
            <img 
              src="/assets/images/kerala_food_sadhya.jpg" 
              alt="Kerala Sadhya" 
              class="w-full h-full object-cover transition duration-500 group-hover:scale-105" 
            />
          </div>
          <div class="p-6 space-y-3 flex-1 flex flex-col justify-between">
            <div class="space-y-2">
              <h3 class="font-heading text-xl dark:text-white">Kerala Sadhya</h3>
              <p class="text-xs leading-relaxed text-stone-600 dark:text-stone-400">
                The ultimate festive feast consisting of 24 to 28 vegetarian dishes served on a fresh banana leaf, traditionally eaten during Onam.
              </p>
            </div>
            <span class="text-[10px] font-bold uppercase tracking-wider text-brand-primary pt-2">Festive Feast</span>
          </div>
        </div>

        <!-- Malabar Biryani -->
        <div class="surface-glass rounded-[2rem] overflow-hidden border border-white/60 dark:border-white/10 flex flex-col justify-between group">
          <div class="aspect-video overflow-hidden">
            <img 
              src="/assets/images/kerala_food_biryani.jpg" 
              alt="Malabar Biryani" 
              class="w-full h-full object-cover transition duration-500 group-hover:scale-105" 
            />
          </div>
          <div class="p-6 space-y-3 flex-1 flex flex-col justify-between">
            <div class="space-y-2">
              <h3 class="font-heading text-xl dark:text-white">Malabar Biryani</h3>
              <p class="text-xs leading-relaxed text-stone-600 dark:text-stone-400">
                Slow-cooked fragrant Khaima rice layered with spiced meat, fried onions, cashews, raisins, and a dollop of pure ghee.
              </p>
            </div>
            <span class="text-[10px] font-bold uppercase tracking-wider text-brand-primary pt-2">Aromatic Delicacy</span>
          </div>
        </div>

        <!-- Karimeen Pollichathu -->
        <div class="surface-glass rounded-[2rem] overflow-hidden border border-white/60 dark:border-white/10 flex flex-col justify-between group">
          <div class="aspect-video overflow-hidden">
            <img 
              src="/assets/images/kerala_food_karimeen.jpg" 
              alt="Karimeen Pollichathu" 
              class="w-full h-full object-cover transition duration-500 group-hover:scale-105" 
            />
          </div>
          <div class="p-6 space-y-3 flex-1 flex flex-col justify-between">
            <div class="space-y-2">
              <h3 class="font-heading text-xl dark:text-white">Karimeen Pollichathu</h3>
              <p class="text-xs leading-relaxed text-stone-600 dark:text-stone-400">
                Pearl Spot fish marinated in a rich, spicy masala, wrapped tightly in fresh banana leaves, and slow-grilled on a griddle.
              </p>
            </div>
            <span class="text-[10px] font-bold uppercase tracking-wider text-brand-primary pt-2">Backwater Seafood</span>
          </div>
        </div>

        <!-- Appam & Stew -->
        <div class="surface-glass rounded-[2rem] overflow-hidden border border-white/60 dark:border-white/10 flex flex-col justify-between group">
          <div class="aspect-video overflow-hidden">
            <img 
              src="/assets/images/kerala_food_appam.jpg" 
              alt="Appam and Stew" 
              class="w-full h-full object-cover transition duration-500 group-hover:scale-105" 
            />
          </div>
          <div class="p-6 space-y-3 flex-1 flex flex-col justify-between">
            <div class="space-y-2">
              <h3 class="font-heading text-xl dark:text-white">Appam & Stew</h3>
              <p class="text-xs leading-relaxed text-stone-600 dark:text-stone-400">
                Lacy fermented rice pancakes with a soft, pillowy center, served with a delicate stew of vegetables or meat cooked in coconut milk.
              </p>
            </div>
            <span class="text-[10px] font-bold uppercase tracking-wider text-brand-primary pt-2">Breakfast Classic</span>
          </div>
        </div>
      </div>
    </section>

    <!-- Life, Festivals & Rejuvenation -->
    <section class="mx-auto max-w-6xl px-5 lg:px-10">
      <div class="surface-glass rounded-[3rem] p-8 sm:p-12 border border-white/60 dark:border-white/10">
        <div class="grid gap-12 lg:grid-cols-2 lg:items-center">
          <div class="space-y-8">
            <span class="inline-flex items-center rounded-full border border-brand-primary/40 bg-brand-primary/20 px-4 py-1.5 text-xs font-semibold uppercase tracking-[0.22em] text-brand-primary">
              Lifestyle & Rhythm
            </span>
            <h2 class="font-heading text-4xl text-stone-900 dark:text-white sm:text-5xl">
              Rhythms of Local Life
            </h2>
            
            <div class="space-y-6 text-stone-600 dark:text-stone-300">
              <div class="space-y-2">
                <h4 class="font-heading text-2xl text-stone-900 dark:text-white">Vallam Kali (Snake Boat Race)</h4>
                <p class="text-sm leading-relaxed">
                  During the harvest festival of Onam, massive wooden snake boats—crewed by over 100 synchronized rowers—slice through the backwaters to the fierce rhythm of traditional rowing songs.
                </p>
              </div>

              <div class="space-y-2 pt-4 border-t border-brand-line dark:border-white/10">
                <h4 class="font-heading text-2xl text-stone-900 dark:text-white">Ayurvedic Wellness</h4>
                <p class="text-sm leading-relaxed">
                  As the birthplace of Ayurveda, Kerala harnesses centuries of holistic medicinal practices. monsoon season is considered the ideal time for detox, utilizing native herbs and medicinal oils.
                </p>
              </div>
            </div>
          </div>

          <div class="relative">
            <div class="aspect-square rounded-[2.5rem] overflow-hidden border border-white/60 dark:border-white/10 shadow-glass">
              <img 
                src="/assets/images/kerala_beach.jpg" 
                alt="Ayurveda and Beach Life in Kerala" 
                class="w-full h-full object-cover" 
              />
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>
