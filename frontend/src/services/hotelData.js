export const districtDirectory = {
  alleppey: {
    title: 'Alleppey',
    subtitle: 'Backwater resorts, houseboat stays, and serene waterfront escapes across Alappuzha.',
  },
  munnar: {
    title: 'Munnar',
    subtitle: 'Tea-country retreats with misty mornings, valley views, and hillside boutique stays.',
  },
  kochi: {
    title: 'Kochi',
    subtitle: 'Heritage hotels, modern city stays, and waterfront hideaways around Fort Kochi and beyond.',
  },
  wayanad: {
    title: 'Wayanad',
    subtitle: 'Forest lodges, plantation villas, and quiet mountain stays set in lush green landscapes.',
  },
}

export const hotelCatalog = {
  alleppey: [
    {
      slug: 'lake-crest-houseboat',
      name: 'Lake Crest Houseboat',
      location: 'Punnamada Lake',
      district: 'alleppey',
      priceCategory: 'Premium',
      priceClass: 'badge-premium',
      tags: ['Backwater', 'Private deck', 'Sunset cruise'],
      tone: 'from-sky-700 via-cyan-500 to-emerald-500',
    },
    {
      slug: 'canal-breeze-inn',
      name: 'Canal Breeze Inn',
      location: 'Alleppey Town',
      district: 'alleppey',
      priceCategory: 'Budget',
      priceClass: 'badge-budget',
      tags: ['Town stay', 'Family rooms', 'Canal view'],
      tone: 'from-sky-500 via-teal-400 to-emerald-300',
    },
    {
      slug: 'coconut-lagoon-suites',
      name: 'Coconut Lagoon Suites',
      location: 'Kainakary',
      district: 'alleppey',
      priceCategory: 'Premium',
      priceClass: 'badge-premium',
      tags: ['Lagoon', 'Spa', 'Private villa'],
      tone: 'from-emerald-900 via-green-700 to-cyan-500',
    },
    {
      slug: 'palm-wharf-residency',
      name: 'Palm Wharf Residency',
      location: 'Mullackal',
      district: 'alleppey',
      priceCategory: 'Standard',
      priceClass: 'badge-standard',
      tags: ['Couple friendly', 'Breakfast', 'Boat access'],
      tone: 'from-cyan-700 via-sky-500 to-emerald-400',
    },
    {
      slug: 'vembanad-budget-rooms',
      name: 'Vembanad Budget Rooms',
      location: 'Mararikulam Road',
      district: 'alleppey',
      priceCategory: 'Budget',
      priceClass: 'badge-budget',
      tags: ['Beach access', 'Flexible stay', 'Local food'],
      tone: 'from-amber-500 via-orange-400 to-sky-400',
    },
    {
      slug: 'marari-tides-retreat',
      name: 'Marari Tides Retreat',
      location: 'Marari Beach',
      district: 'alleppey',
      priceCategory: 'Standard',
      priceClass: 'badge-standard',
      tags: ['Beachfront', 'Pool', 'Quiet zone'],
      tone: 'from-slate-700 via-sky-700 to-cyan-500',
    },
  ],
  munnar: [
    {
      slug: 'munnar-cloud-house',
      name: 'Munnar Cloud House',
      location: 'Tea Valley Viewpoint',
      district: 'munnar',
      priceCategory: 'Standard',
      priceClass: 'badge-standard',
      tags: ['Hill escape', 'Breakfast', 'Mountain view'],
      tone: 'from-emerald-800 via-green-700 to-lime-500',
    },
    {
      slug: 'mistline-estate-stay',
      name: 'Mistline Estate Stay',
      location: 'Old Munnar Road',
      district: 'munnar',
      priceCategory: 'Premium',
      priceClass: 'badge-premium',
      tags: ['Tea estate', 'Spa', 'Private deck'],
      tone: 'from-green-950 via-emerald-700 to-lime-400',
    },
  ],
  kochi: [
    {
      slug: 'fort-kochi-veranda',
      name: 'Fort Kochi Veranda',
      location: 'Fort Kochi',
      district: 'kochi',
      priceCategory: 'Premium',
      priceClass: 'badge-premium',
      tags: ['Heritage', 'Boutique', 'Art district'],
      tone: 'from-slate-800 via-sky-700 to-cyan-500',
    },
    {
      slug: 'harbor-line-residency',
      name: 'Harbor Line Residency',
      location: 'Marine Drive',
      district: 'kochi',
      priceCategory: 'Standard',
      priceClass: 'badge-standard',
      tags: ['City stay', 'Business', 'Breakfast'],
      tone: 'from-slate-900 via-sky-800 to-cyan-400',
    },
  ],
  wayanad: [
    {
      slug: 'wayanad-forest-mist',
      name: 'Wayanad Forest Mist',
      location: 'Vythiri',
      district: 'wayanad',
      priceCategory: 'Budget',
      priceClass: 'badge-budget',
      tags: ['Rainforest', 'Family rooms', 'Pool'],
      tone: 'from-green-950 via-emerald-800 to-teal-500',
    },
    {
      slug: 'ridgewood-hideaway',
      name: 'Ridgewood Hideaway',
      location: 'Kalpetta',
      district: 'wayanad',
      priceCategory: 'Premium',
      priceClass: 'badge-premium',
      tags: ['Private deck', 'Spa', 'Forest view'],
      tone: 'from-green-900 via-teal-700 to-cyan-500',
    },
  ],
}

export const priceOptions = ['All', 'Budget', 'Standard', 'Premium']

export const tagOptions = [
  'Backwater',
  'Beachfront',
  'Private deck',
  'Spa',
  'Family rooms',
  'Breakfast',
  'Pool',
]

export const getDistrictBySlug = (slug) => districtDirectory[slug] || districtDirectory.alleppey
