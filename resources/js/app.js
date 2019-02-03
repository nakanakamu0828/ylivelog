import Vue from 'vue'
import Vuelidate from 'vuelidate'
import VueCookies from 'vue-cookies'
import VueHead from 'vue-head'
import App from './components/App.vue'
import router from './router'
import store from './store'

Vue.use(Vuelidate)
Vue.use(VueCookies)
Vue.use(VueHead)

const app = document.getElementById('app');
if (app) {
  const currentUser = app.dataset.user
  if (currentUser) {
    store.dispatch('auth/setUser', JSON.parse(currentUser))
  }

  new Vue({
    el: '#app',
    router,
    store,
    components: { App },
    template: '<App />',
  })
}
