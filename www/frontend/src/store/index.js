import Vue from 'vue'
import Vuex from 'vuex'
import files from './modules/files'
import images from './modules/images'
import users from './modules/users'


Vue.use(Vuex)

export default new Vuex.Store({
  modules: {
    files,
    images,
    users,
  },
})
