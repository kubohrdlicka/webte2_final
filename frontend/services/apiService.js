import Axios from 'axios'
import { useToast } from 'vue-toastification'
import i18n from '../plugins/i18n'

const toast = useToast()

const apiClient = Axios.create({
  baseURL: import.meta.env.VITE_URL,
  headers: {
    Accept: 'application/json',
    'Content-Type': 'application/x-www-form-urlencoded',
  },
})

function getAuthHeader() {
  return { headers: { Authorization: 'Bearer ' + sessionStorage.getItem('token') }}
}

export default {
  async get (url, options = {}) {
    const credentials = getAuthHeader()
    return apiClient
      .get(url, credentials)
      .then((response) => {
        if( !response.data && response.status !== 200) {
          throw new Error
        }
        return response
      })
      .catch((e) => {
        if (!options.alert || options.alert.failure !== false) {
          this.handleGetError(e)
        }
        return false
      })
  },
  async post (url, body, options = {}) {
    const credentials = getAuthHeader()
    return apiClient
      .post(url, body, credentials)
      .then((response) => {
        if (!options.alert || options.alert.success !== false) {
          toast.success(`${i18n.global.t('messages.postSuccess')}`)
        }
        return response
      })
      .catch((e) => {
        if (!options.alert || options.alert.failure !== false) {
          this.handleGetError(e)
        }
        return false
      })
  },
  async put (url, body) {
    const credentials = getAuthHeader()
    return apiClient
      .put(url, body, credentials)
      .then((response) => {
        toast.success(`${i18n.global.t('messages.putSuccess')}`)
        return response
      })
      .catch((e) => {
        this.handlePutError(e)
        return false
      })
  },
  async delete (url, options = {}) {
    const credentials = getAuthHeader()
    return apiClient
      .delete(url, credentials)
      .then((response) => {
        if (!options.alert || options.alert.success !== false) {
          toast.success(`${i18n.global.t('messages.deleteSuccess')}`)
        }
        return response
      })
      .catch((e) => {
        this.handleDeleteError(e)
        return false
      })
  },
  handleGetError (error) {
    toast.error(`${i18n.global.t('message.getError')} (${error.response.status})`)
  },
  handlePostError (error) {
    toast.error(`${i18n.global.t('message.postError')} (${error.response.status})`)
  },
  handlePutError (error) {
    toast.error(`${i18n.global.t('message.putError')} (${error.response.status})`)
  },
  handleDeleteError (error) {
    toast.error(`${i18n.global.t('message.deleteError')} (${error.response.status})`)
  },
}