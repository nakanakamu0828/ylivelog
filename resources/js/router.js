import Vue from 'vue'
import VueRouter from 'vue-router'

import Home from '~/components/pages/Home.vue'
import Archive from '~/components/pages/archive/index.vue'
import ArchiveShow from '~/components/pages/archive/show.vue'
import NotFound from '~/components/pages/NotFound.vue'

import store from './store'

// VueRouterプラグインを使用する
// これによって<RouterView />コンポーネントなどを使うことができる
Vue.use(VueRouter)

// パスとコンポーネントのマッピング
const routes = [
  {
    path: '/',
    component: Home
  },
  {
    path: '/archives',
    component: Archive,
    beforeEnter (to, from, next) {
      if (store.getters['auth/isLoggined']) {
        next()
      } else {
        next('/')
      }
    }
  },
  {
    path: '/archive/:id',
    component: ArchiveShow,
    beforeEnter (to, from, next) {
      if (store.getters['auth/isLoggined']) {
        next()
      } else {
        next('/')
      }
    }
  },
  {
    path: '*',
    component: NotFound,
  }
]

// VueRouterインスタンスを作成する
const router = new VueRouter({
    mode: 'history',
    routes
})
  
// VueRouterインスタンスをエクスポートする
// app.jsでインポートするため
export default router