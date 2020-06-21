import Vue from 'vue'
import App from './App.vue'
import Store from './store'
import Router from "./router/router";
import 'bootstrap/dist/css/bootstrap.css'
import "bootstrap-vue/dist/bootstrap-vue.css"
import { BootstrapVue } from 'bootstrap-vue'

Vue.use(BootstrapVue)

new Vue({
  store: Store,
  router: Router,
  render: h => h(App)
}).$mount('#app');

