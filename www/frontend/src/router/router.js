import Vue from 'vue'
import Router from 'vue-router'
import Home from '@/views/Home'
import Gallery from '@/views/Gallery'

Vue.use(Router)

export default new Router({
  mode: 'history',
  routes:[
    {
      path: '/',
      name: 'Home',
      component: Home,
    },
    {
      path: '/gallery',
      name: 'Gallery',
      component: Gallery,
    },
  ]
})
