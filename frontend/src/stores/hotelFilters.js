import { computed, ref } from 'vue'
import { defineStore } from 'pinia'
import { createRequestState } from '../services/api'
import { fetchHotels } from '../services/hotels'

const DEFAULT_DISTRICT = 'alleppey'
const DEFAULT_PRICE_CATEGORY = 'All'
const DEBOUNCE_MS = 350

export const useHotelFiltersStore = defineStore('hotelFilters', () => {
  // --- State ---
  const selectedDistrict = ref(DEFAULT_DISTRICT)
  const priceCategory = ref(DEFAULT_PRICE_CATEGORY)
  const selectedTags = ref([])
  const hotels = ref([])
  
  // UI State (loading, error)
  const requestState = createRequestState()
  const { loading: isLoading, error } = requestState

  // --- Internals ---
  let debounceTimer = null
  let controller = null

  const filters = computed(() => ({
    selectedDistrict: selectedDistrict.value,
    priceCategory: priceCategory.value,
    selectedTags: selectedTags.value,
  }))

  const clearPendingRequest = () => {
    if (debounceTimer) {
      clearTimeout(debounceTimer)
      debounceTimer = null
    }

    if (controller) {
      controller.abort()
      controller = null
    }
  }

  // --- Actions ---
  
  /**
   * Fetch hotels from the API based on current filters
   */
  const loadHotels = async () => {
    // Abort any existing request
    if (controller) {
      controller.abort()
    }

    controller = new AbortController()

    try {
      hotels.value = await fetchHotels(filters.value, {
        signal: controller.signal,
        state: requestState,
      })
    } catch (e) {
      // Ignore abort errors
      if (e.name !== 'AbortError' && e.name !== 'CanceledError') {
        console.error('Failed to load hotels:', e)
      }
    }
  }

  /**
   * Debounced version of loadHotels
   */
  const loadHotelsDebounced = () => {
    if (debounceTimer) {
      clearTimeout(debounceTimer)
    }

    debounceTimer = setTimeout(() => {
      loadHotels()
    }, DEBOUNCE_MS)
  }

  /**
   * Update multiple filters at once
   */
  const setFilters = (payload = {}) => {
    if (payload.selectedDistrict !== undefined) {
      selectedDistrict.value = payload.selectedDistrict
    }

    if (payload.priceCategory !== undefined) {
      priceCategory.value = payload.priceCategory
    }

    if (payload.selectedTags !== undefined) {
      selectedTags.value = payload.selectedTags
    }

    loadHotelsDebounced()
  }

  /**
   * Toggle a specific tag in the filters
   */
  const toggleTag = (tag) => {
    const index = selectedTags.value.indexOf(tag)
    if (index === -1) {
      selectedTags.value.push(tag)
    } else {
      selectedTags.value.splice(index, 1)
    }

    loadHotelsDebounced()
  }

  /**
   * Reset all filters to default
   */
  const resetFilters = () => {
    selectedDistrict.value = DEFAULT_DISTRICT
    priceCategory.value = DEFAULT_PRICE_CATEGORY
    selectedTags.value = []

    loadHotelsDebounced()
  }

  return {
    // State
    selectedDistrict,
    priceCategory,
    selectedTags,
    hotels,
    isLoading,
    error,
    
    // Actions
    setFilters,
    resetFilters,
    toggleTag,
    loadHotels,
    loadHotelsDebounced,
    clearPendingRequest,
  }
})
