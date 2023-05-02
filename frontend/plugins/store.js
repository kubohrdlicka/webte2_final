import axios from 'axios'
import { createStore } from 'vuex'

const store = createStore({
  state () {
    return {
      authentificated: false,
      token: null,
      role: null,
      intervalId: null
      
    }
  },
  mutations: {
    setAuthentificated (state, value) {
      state.authentificated = value
    },
    setToken (state, value) {
      state.token = value
    },
    setRole (state, value) {
      state.role = value
    },
    setIntervalId (state, value) {
      state.intervalId = value
    }



  },
  actions: {
    login (state, {token, role}) {
      let intervalId = setInterval(async() => {
        let data = await axios.get(import.meta.env.VITE_URL + '/api/account/refresh', {headers: {Authorization: 'Bearer ' + sessionStorage.getItem('token')}}).then(
          response => {
            sessionStorage.setItem('token', response.data.token)
            this.commit('setToken', response.data.token)
          })
      }, 1000 * 60 * 5)
      sessionStorage.setItem('auth', true)
      this.commit('setIntervalId', intervalId)
      this.commit('setAuthentificated', true)
      this.commit('setToken', token)
      this.commit('setRole', role)
    }


  },
})

export default store
