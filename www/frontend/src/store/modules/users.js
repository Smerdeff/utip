import Vue from 'vue'
import Axios from 'axios'


export default {
  state: {
    status: '',
    token: localStorage.getItem('token') || '',
    user: {}
  },
  mutations: {
    AUTH_REQUEST(state) {
      state.status = 'loading'
    },
    AUTH_SUCCESS(state, payload) {
      state.status = 'success'
      state.token = payload.token
      state.user = payload.user
      // console.log( payload)
    },
    AUTH_ERROR(state) {
      state.status = 'error'
    },
    LOGOUT(state) {
      state.status = ''
      state.token = ''
    },
  },
  actions: {
    LOGIN({commit}, user) {
      // console.log(user)
      return new Promise((resolve, reject) => {
        commit('AUTH_REQUEST')
        Axios.post('http://localhost/api/accounts/login/', user)
          .then(resp => {
            // console.log(resp.data);
            const token = resp.data.token
            const user = resp.data.user
            localStorage.setItem('token', token)
            // Add the following line:
            Axios.defaults.headers.common['Authorization'] = token
            commit('AUTH_SUCCESS', {token:token, user:user})
            resolve(resp)
          })
          .catch(err => {
            commit('AUTH_ERROR')
            localStorage.removeItem('token')
            reject(err)
          })
      })
    },

    TOKEN_LOGIN(context) {
      Axios.defaults.headers.common['Authorization'] = context.state.token
      Axios.get(`http://localhost/api/accounts/${context.state.token}`, )
        .then(resp => {
          const user = resp.data.user
          // Axios.defaults.headers.common['Authorization'] = context.state.token
          context.commit('AUTH_SUCCESS', {token: context.state.token, user:user})
          // resolve(resp)
        })
        .catch(err => {
          context.commit('AUTH_ERROR', err)
          localStorage.removeItem('token')
          // reject(err)
        })
    },
    REGISTER({commit}, user) {
      // return new Promise((resolve, reject) => {
      //   commit('AUTH_SUCCESS')

        Axios.post('http://localhost/api/accounts/register/', user)
          .then(resp => {
            const token = resp.data.token
            const user = resp.data.user
            localStorage.setItem('token', token)
            // Add the following line:
            Axios.defaults.headers.common['Authorization'] = token
            commit('AUTH_SUCCESS', {token:token, user:user})
            // resolve(resp)
          })
          .catch(err => {
            commit('AUTH_ERROR', err)
            localStorage.removeItem('token')
            // reject(err)
          })
      // })
    },
    LOGOUT({commit}) {
      return new Promise((resolve, reject) => {
        commit('LOGOUT')
        localStorage.removeItem('token')
        delete Axios.defaults.headers.common['Authorization']
        resolve()
      })
    }
  },
  getters: {
    USER: state => state.user,
    TOKEN: state => state.token,
    isLoggedIn: state => !!state.token,
    authStatus: state => state.status,
  }
}
