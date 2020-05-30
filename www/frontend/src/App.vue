<template>
    <div id="app">
        <H1>Task application1</H1>
        <hr>
        <TaskList
                v-bind:tasks="listTasks"
        />
        <!--        <div class="task" v-for="task in listTasks.data" :key="task.id">-->
        <!--            <h4>{{task.username}}</h4>-->
        <!--            <p>{{task.body}}</p>-->
        <!--        </div>-->
    </div>
</template>

<script>


  import {mapGetters, mapActions} from 'vuex';
  import TaskList from '@/components/TaskList'

  export default {
    name: 'app',
    computed: mapGetters(['listTasks']),
    methods: mapActions(['readTasks']),
    async mounted() {
      // this.$store.dispatch('readTasks')
      this.readTasks();
    },

    components: {
      TaskList
    }
  }
</script>
<style>
    #app {
        font-family: Avenir, Helvetica, Arial, sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        text-align: center;
        color: #2c3e50;
    }

    #nav {
        padding: 30px;
    }

    #nav a {
        font-weight: bold;
        color: #2c3e50;
    }

    #nav a.router-link-exact-active {
        color: #42b983;
    }
</style>
