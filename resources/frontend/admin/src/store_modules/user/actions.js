import axios from 'axios'
import authConfig from './utils'

export default {
  login ({ commit }, credentials) {
    return axios.post('auth/login', credentials)
      .then(({ data }) => {
        commit('authSuccess', data)
      })
      .catch((error) => {
        console.error(error)
        commit('authFailed')
        return Promise.reject(error)
      })
  },
  logOut ({ commit }) {
    return axios.post('auth/logout', '', authConfig())
      .then(() => {
        commit('authFailed')
      })
      .catch((error) => {
        console.error(error)
      })
  },
  register ({ commit }, credentials) {
    return axios.post('auth/register', credentials)
      .then(({ data }) => {
        commit('authSuccess', data)
      })
      .catch((error) => {
        console.error(error)
        commit('authFailed')
        return Promise.reject(error)
      })
  },
  checkUser ({ commit }) {
    return axios.post('auth/me', '', authConfig())
      .then(({ data }) => {
        commit('authSuccess', data)
        return Promise.resolve(data)
      })
      .catch((error) => {
        commit('authFailed')
        return Promise.reject(error)
      })
  },
}
