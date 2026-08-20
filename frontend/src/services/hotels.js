import { getHotels } from './hotelApi'
import {
  districtDirectory,
  getDistrictBySlug,
  hotelCatalog,
  priceOptions,
  tagOptions,
} from './hotelData'

export { districtDirectory, getDistrictBySlug, hotelCatalog, priceOptions, tagOptions }

const filterLocalHotels = ({ selectedDistrict, priceCategory, selectedTags }) => {
  const hotels = hotelCatalog[selectedDistrict] || hotelCatalog.alleppey

  return hotels.filter((hotel) => {
    const matchesPrice = priceCategory === 'All' || hotel.priceCategory === priceCategory
    const matchesTags = selectedTags.length === 0 || selectedTags.every((tag) => hotel.tags.includes(tag))

    return matchesPrice && matchesTags
  })
}

export const fetchHotels = async (filters, options = {}) => {
  try {
    return await getHotels(filters, {
      signal: options.signal,
      state: options.state,
      fallback: () => filterLocalHotels(filters),
    })
  } catch (error) {
    if (error.name === 'AbortError' || error.name === 'CanceledError') {
      throw error
    }

    return filterLocalHotels(filters)
  }
}
