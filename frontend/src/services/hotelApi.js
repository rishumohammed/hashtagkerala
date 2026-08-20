import { apiClient, runServiceAction } from './api'

const normalizeCollection = (payload) => {
  if (Array.isArray(payload)) return payload
  if (Array.isArray(payload?.data)) return payload.data
  return []
}

const normalizeItem = (payload) => payload?.data ?? payload ?? null

const buildHotelParams = (filters = {}) => {
  const params = {}

  if (filters.selectedDistrict) {
    params.district = filters.selectedDistrict
  }

  if (filters.priceCategory && filters.priceCategory !== 'All') {
    params.price_category = filters.priceCategory
  }

  if (filters.selectedTags?.length) {
    params['tags[]'] = filters.selectedTags
  }

  return params
}

/**
 * Fetch all districts
 */
export const getDistricts = (options = {}) =>
  runServiceAction(() => apiClient.get('/districts', { signal: options.signal }), {
    ...options,
    transform: (response) => normalizeCollection(response.data),
  })

/**
 * Fetch hotels with filters
 */
export const getHotels = (filters = {}, options = {}) =>
  runServiceAction(
    () =>
      apiClient.get('/hotels', {
        params: buildHotelParams(filters),
        signal: options.signal,
      }),
    {
      ...options,
      transform: (response) => normalizeCollection(response.data),
    },
  )

/**
 * Fetch a single hotel by its slug
 */
export const getHotelBySlug = (slug, options = {}) =>
  runServiceAction(() => apiClient.get(`/hotels/${slug}`, { signal: options.signal }), {
    ...options,
    transform: (response) => normalizeItem(response.data),
  })

/**
 * Fetch all available hotel tags
 */
export const getTags = (options = {}) =>
  runServiceAction(() => apiClient.get('/tags', { signal: options.signal }), {
    ...options,
    transform: (response) => normalizeCollection(response.data),
  })
