<template>
    <li class="list-group-item">
        <strong class="float-left">{{task.id}}</strong>
        <div>
            <span>{{task.created_at}}</span>
            <span>{{task.username}}</span>
        </div>
        <span>{{task.body}}</span>
        <b-button variant="danger" @click="DESTROY_TASKS(task)" >&times;</b-button>
    </li>
</template>

<script>
  import {mapActions} from 'vuex';
  export default {
    name: "TaskItem",
    props: {
      task: {
        Object,
        required: true,
      }
    },
    methods: mapActions(['DESTROY_TASKS']),

  }

  // console.log(task);

</script>

<style scoped>


</style>
