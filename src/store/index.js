import Vue from 'vue'
import Vuex from 'vuex'

import BoardModule from './board'

Vue.use(Vuex)

const store = new Vuex.Store({
  modules: {
    'kanban': BoardModule
  }
})

export default store
