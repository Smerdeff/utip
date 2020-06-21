<template>
    <div>
        <H2>Task application</H2>
        <router-link to="/taskform" tag="button" class="btn btn-primary">Add</router-link>
        <TaskList
                v-bind:tasks="TASKS"
        />
    </div>
</template>

<script>
  import {mapGetters, mapActions} from 'vuex';
  import TaskList from '@/components/TaskList'
  import TaskForm from "@/views/TaskForm";

  export default {
    name: 'Tasks',
    computed: mapGetters(['TASKS']),
    methods: mapActions(['READ_TASKS']),
    async mounted() {
      this.READ_TASKS();
    },

    components: {
      TaskList,
      TaskForm,

    }
  }
</script>

<style scoped>

</style>
