
import http from '~/plugins/http.js'
export default {
  setUser: ({ commit }, value) => {
    commit('SET_USER', value)
  },
  
  async logout({ commit }) {
    await http.post('/api/logout')
    commit('SET_USER', null)
  }
}

