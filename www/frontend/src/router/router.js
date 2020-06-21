import Vue from 'vue'
import Router from 'vue-router'
import Home from '@/views/Home'
import Tasks from '@/views/Tasks'
import TaskForm from '@/views/TaskForm'
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
      path: '/tasks',
      name: 'Tasks',
      component: Tasks,
    },
    {
      path: '/taskform',
      name: 'TaskForm',
      component: TaskForm,
      props: true,
    },
    {
      path: '/gallery',
      name: 'Gallery',
      component: Gallery,
    },
  ]
})
