const fallbackApiBaseUrl = 'http://localhost/hashtag-kerala/backend/public/api'

export const useApiBaseUrl = () => {
  return import.meta.env.VITE_API_BASE_URL || fallbackApiBaseUrl
}
