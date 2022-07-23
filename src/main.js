import Vue from 'vue'
import App from './App.vue'
import axios from 'axios'

import store from './store'

import router from './router'

import vuetify from './plugins/vuetify'
import './assets/scss/theme.scss'

axios.defaults.baseURL = process.env.VUE_APP_API_URL
Vue.config.productionTip = false

export default new Vue({
  vuetify,
  router,
  store,
  render: (h) => h(App)
}).$mount('#app')
