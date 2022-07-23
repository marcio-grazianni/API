import '@mdi/font/css/materialdesignicons.css'

import Vue from 'vue'

import Vuetify from 'vuetify/lib/framework'

import * as directives from 'vuetify/lib/directives'

Vue.use(Vuetify, {
  directives
})

export default new Vuetify({
  icons: {
    iconfont: 'mdi'
  }
})
