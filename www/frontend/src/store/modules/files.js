import Vue from 'vue'
import Axios from 'axios'


export default {
  state: {
    files: [],
    is_add_mode: false,
  },
  getters: {
    FILES(state) {
      return state.files
    },
    IS_ADD_MODE(state) {
      return state.is_add_mode
    },
  },
  mutations: {
    SET_FILES: (state, files) => {
      state.files = files
    },
    SWITCH_ADD_MODE: (state) => {
      state.is_add_mode = !state.is_add_mode
      // console.log(state.is_add_mode )
    },
    ADD_FILE: (state, file) => {
      const index = state.files.findIndex(item => item.name === file.name)
      if (index >= 0) {

      } else {
        state.files.push(file)
      }
    },
    DELETE_FILES: (state) => {
      state.files = []
    },

    DELETE_FILE: (state, file) => {
      const index = state.files.findIndex(item => item.name === file.name)
      if (index >= 0) {
        // console.log(file)
        Vue.delete(state.files, index);
      }
    },

    COMMIT_FILES: (state) => {
      state.files = []
    },

  },
  actions: {
    ADD_MODE: async (context) => {
      context.commit('SWITCH_ADD_MODE')
    },
    // READ_TASKS: async (context) => {
    //   await Axios
    //     .get(`http://localhost/api/tasks/`)
    //     .then(response => {
    //       context.commit('SET_TASKS', response.data)
    //     })
    //     .catch(error => console.log(error));
    // },
    // RETRIEVE_TASKS: async (context) => {
    //   await Axios
    //     .delete(`http://localhost/api/tasks/${task.id}`)
    //     .then(response => {
    //       context.commit('SET_TASK', task)
    //     })
    //     .catch(error => console.log(error));
    // },
    UPDATE_FILES: (context, files) => {
      files.forEach((value, index) => {
        context.commit('ADD_FILE', value)
      })
    },
    CLEAR_FILES: (context) => {
      context.commit('DELETE_FILES')
    },

    POST_FILE: async (context, file) => {
      let formData = new FormData();
      formData.append('file', file);
      await Axios
        .post(`http://localhost/api/images/upload`,
          formData,
          {
            headers: {
              'Content-Type': 'images'
            },
            // onUploadProgress: progressEvent => console.log(progressEvent.loaded) //TODO upload progress
          })
        .then(response => {
          context.commit('DELETE_FILE', file)
          context.commit('ADD_IMAGE', response.data)
        })
        .catch(error => console.log(error));
    },

    // CREATE_TASKS: async (context, task) => {
    //   await Axios
    //     .post(`http://localhost/api/tasks/`)
    //     .then(response => {
    //       context.commit('DELETE_TASKS', task)
    //     })
    //     .catch(error => console.log(error));
    // },
    // DESTROY_TASKS: async (context, task) => {
    //   console.log(task);
    //   return
    //   await Axios
    //     .delete(`http://localhost/api/tasks/${task.id}`)
    //     .then(response => {
    //       context.commit('DELETE_TASKS', task)
    //     })
    //     .catch(error => console.log(error));
    // },
  },

}
