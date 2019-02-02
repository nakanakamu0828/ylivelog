import Vue from 'vue'
import Vuex from 'vuex'
import auth from '~/store/modules/auth';

Vue.use(Vuex)

const store = new Vuex.Store({
  state: {
    isLoading: false,
  },
  mutations: {
    SET_LOADING: (state, payload) => { state.isLoading = payload }
  },
  actions: {
    setLoading: ({ commit }, value) => {
      commit('SET_LOADING', value)
    },
  },
  getters: {
    isLoading: state => state.isLoading,
  },
  modules: {
    auth
  }
})

export default store
