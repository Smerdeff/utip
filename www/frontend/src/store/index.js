import Vue from 'vue'
import Vuex from 'vuex'
import tasks from './modules/tasks'
import files from './modules/files'
import images from './modules/images'



Vue.use(Vuex)

export default new Vuex.Store({
  modules: {
    tasks,
    files,
    images,
  },
})
