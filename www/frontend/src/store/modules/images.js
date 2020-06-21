import Vue from 'vue'
import Axios from 'axios'


export default {
  state: {
    images: [],
  },
  getters: {
    IMAGES(state) {
      return state.images
    },

  },
  mutations: {
    SET_IMAGES: (state, images) => {
      state.images = images
    },
    ADD_IMAGE: (state, image) => {
      const index = state.images.findIndex(item => item.name == image.name)
      if (index >= 0) {

      } else {
        state.images.push(image)
      }
    },
    DELETE_IMAGE: (state, image) => {
      const index = state.images.findIndex(item => item.name == image.name)
      if (index >= 0) {
        Vue.delete(state.images, index);
      }
    },

  },
  actions: {
    READ_IMAGES: async (context) => {
      await Axios
        .get(`http://localhost/api/images/`)
        .then(response => {
          context.commit('SET_IMAGES', response.data)
        })
        .catch(error => console.log(error));
    },
    RETRIEVE_IMAGES: async (context) => {
      await Axios
        .get(`http://localhost/api/images/${task.id}`)
        .then(response => {
          context.commit('SET_IMAGE', task)
        })
        .catch(error => console.log(error));
    },
    UPDATE_IMAGES: async (context, task) => {
      await Axios
        .put(`http://localhost/api/images/${task.id}`)
        .then(response => {
          context.commit('UPDATE_IMAGE', task)
        })
        .catch(error => console.log(error));
    },
    DESTROY_IMAGES: async (context, image) => {
      await Axios
        .delete(`http://localhost/api/images/${task.id}`)
        .then(response => {
          context.commit('DELETE_IMAGE', image)
        })
        .catch(error => console.log(error));
    },

  },

}
