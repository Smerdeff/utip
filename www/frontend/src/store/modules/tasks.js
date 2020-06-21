import Vue from 'vue'
import Axios from 'axios'


export default {
  state: {
    tasks: [],
    task:{},
  },
  getters: {
    TASKS(state) {
      return state.tasks
    },
    TASK(state) {
      return state.task
    },
  },
  mutations: {
    SET_TASKS: (state, tasks) => {
      state.tasks = tasks
    },
    SET_TASK: (state, task) => {
      state.task = task
    },
    ADD_TASK: (state, task) => {
      state.tasks.push(task)
    },
    DELETE_TASKS: (state, task) => {
      const index = state.tasks.data.findIndex(item => item.id == task.id);
      Vue.delete(state.tasks.data, index);
    },

  },
  actions: {
    READ_TASKS: async (context) => {
      await Axios
        .get(`http://localhost/api/tasks/`)
        .then(response => {
          context.commit('SET_TASKS', response.data)
        })
        .catch(error => console.log(error));
    },
    RETRIEVE_TASKS: async (context) => {
      await Axios
        .delete(`http://localhost/api/tasks/${task.id}`)
        .then(response => {
          context.commit('SET_TASK', task)
        })
        .catch(error => console.log(error));
    },
    UPDATE_TASKS: async (context, task) => {
      await Axios
        .put(`http://localhost/api/tasks/${task.id}`)
        .then(response => {
          context.commit('DELETE_TASKS', task)
        })
        .catch(error => console.log(error));
    },
    CREATE_TASKS: async (context, task) => {
      await Axios
        .post(`http://localhost/api/tasks/`)
        .then(response => {
          context.commit('DELETE_TASKS', task)
        })
        .catch(error => console.log(error));
    },
    DESTROY_TASKS: async (context, task) => {
      console.log(task);
      return
      await Axios
        .delete(`http://localhost/api/tasks/${task.id}`)
        .then(response => {
          context.commit('DELETE_TASKS', task)
        })
        .catch(error => console.log(error));


    },
  },


}
