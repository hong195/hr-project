import router from '@/router'

export default {
  state: {
    user: {},
    isAdmin: false,
    isSubscriber: false,
    hasPermission: false,
  },
  getters: {
    user: state => state.user,
    isAdmin: state => state.user.role === 'admin',
    isSubscriber: state => state.user.role === 'user',
    hasPermission: state => type => state.user.permissions.includes(type),
  },
  mutations: {
    setUser (state, payload) {
      state.user = payload
    },
  },
  actions: {
    login ({ commit }, username, password) {
      localStorage.setItem('token', 'fjkdhgiutrjgiuerbghjfbhje')
      const user = {
        id: 1,
        name: username,
        role: 'admin',
        permissions: ['view', '', 'create', 'delete'],
      }
      commit('setUser', user)
      commit('successMessage', 'You are logged in')
      router.push({ name: 'Dashboard' })
    },
    logout ({ commit }) {
      const user = {}
      commit('setUser', user)
      localStorage.setItem('token', '')
      router.push({ name: 'login' })
    },
  },
}
