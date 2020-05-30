export default {
  actions: {
    async readTasks(context) {
      const res = await fetch("http://localhost/api/tasks/")
      const tasks = await res.json()
      context.commit('mtTasks', tasks)
    }
  },
  mutations: {
    mtTasks(state, tasks){
      state.tasks = tasks
    }
  },
  state: {
    tasks:[]
  },
  getters: {
    listTasks(state){
      return state.tasks

    }
  },

}
