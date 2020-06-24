import Vue from 'vue'
import Axios from 'axios'

export default {
  state: {
    images: [],
    is_select_mode: false,
    selected: [],
    search: '',
  },
  getters: {
    IMAGES(state) {
      return state.images.reverse()

    },
    IS_SELECT_MODE(state) {
      return state.is_select_mode
    },
    SEARCH(state) {
      return state.search
    }

  },
  mutations: {
    SWITCH_SELECT_MODE: (state) => {
      state.is_select_mode = !state.is_select_mode
    },

    SET_SEARCH: (state, value) => {
      state.search = value
    },
    SET_SELECTED: (state, payload) => {
      const index = state.selected.indexOf(payload.id)
      if ((payload.selected) && (index < 0)) {
        state.selected.push(payload.id)
      }
      if ((index >= 0) && (!payload.selected)) {
        Vue.delete(state.selected, index);
      }
    },

    SET_IMAGES: (state, images) => {
      state.images = images.data
    },
    ADD_IMAGE: (state, image) => {
      // console.log(image)
      const index = state.images.findIndex(item => item.id === image[0].id)
      if (index < 0) {
        state.images.push(image[0])
      }
    },

    DELETE_IMAGE: (state, id) => {
      const index = state.images.findIndex(item => item.id === id)
      if (index >= 0) {
        Vue.delete(state.images, index);
      }
    },

  },
  actions: {
    SELECT_MODE: async (context) => {
      context.commit('SWITCH_SELECT_MODE')
    },
    UPDATE_SELECTED: async (context, payload) => {
      context.commit('SET_SELECTED', payload)
    },

    UPDATE_SEARCH: (context, value) => {
        context.commit('SET_SEARCH', value)
    },

    DESTROY_SELECTED_IMAGES: (context) => {
      context.state.selected.forEach((value) => {
        Axios
          .delete(`http://localhost/api/images/${value}`)
          .then(response => {
            context.commit('DELETE_IMAGE', value)
          })
          .catch(error => console.log(error));

      })
    },

    READ_IMAGES: async (context) => {
      // console.log(context.state.search)
      await Axios
        .get(`http://localhost/api/images/?search=${context.state.search}`)
        .then(response => {
          context.commit('SET_IMAGES', response.data)
        })
        .catch(error => console.log(error));
    },
    // RETRIEVE_IMAGES: async (context) => {
    //   await Axios
    //     .get(`http://localhost/api/images/${task.id}`)
    //     .then(response => {
    //       context.commit('SET_IMAGE', task)
    //     })
    //     .catch(error => console.log(error));
    // },
    UPDATE_IMAGES: async (context, image) => {
      // console.log(image)
      await Axios
        .put(`http://localhost/api/images/${image.id}`
          , image
        )
        .then(response => {
          // context.commit('UPDATE_IMAGE', image)
        })
        .catch(error => console.log(error));
    },
    DESTROY_IMAGES: async (context, image) => {
      await Axios
        .delete(`http://localhost/api/images/${image.id}`)
        .then(response => {
          context.commit('DELETE_IMAGE', image.id)
        })
        .catch(error => console.log(error));
    },

  },

}
