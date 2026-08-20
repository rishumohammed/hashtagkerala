import axios from 'axios'
import { ref } from 'vue'
import { useApiBaseUrl } from '../composables/useApiBaseUrl'

export const apiBaseUrl = useApiBaseUrl()

export const apiClient = axios.create({
  baseURL: apiBaseUrl,
  headers: {
    Accept: 'application/json',
    'Content-Type': 'application/json',
  },
})

/**
 * Creates an object to track request states
 */
export const createRequestState = () => ({
  loading: ref(false),
  error: ref(null),
})

/**
 * Normalizes Axios/Network errors into a user-friendly format
 */
export const normalizeApiError = (error) => {
  if (axios.isCancel(error) || error?.name === 'AbortError' || error?.name === 'CanceledError') {
    return error
  }

  const message =
    error?.response?.data?.message ||
    error?.message ||
    'Something went wrong while contacting the server.'

  const normalizedError = new Error(message)
  normalizedError.status = error?.response?.status ?? null
  normalizedError.cause = error

  return normalizedError
}

/**
 * Higher-order function to run service actions with state management
 */
export const runServiceAction = async (request, options = {}) => {
  const { state, transform, fallback } = options

  if (state?.loading) state.loading.value = true
  if (state?.error) state.error.value = null

  try {
    const response = await request()
    return typeof transform === 'function' ? transform(response) : response.data
  } catch (error) {
    if (axios.isCancel(error) || error?.name === 'AbortError' || error?.name === 'CanceledError') {
      throw error
    }

    const normalizedError = normalizeApiError(error)
    if (state?.error) state.error.value = normalizedError

    if (typeof fallback === 'function') {
      return fallback(normalizedError)
    }

    throw normalizedError
  } finally {
    if (state?.loading) state.loading.value = false
  }
}
