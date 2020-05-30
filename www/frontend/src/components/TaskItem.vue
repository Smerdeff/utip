<template>
    <li>
        <strong>{{task.username}}</strong>
        <span>{{task.body}}</span>
        <button>&times;</button>
    </li>
</template>


<script>
  export default {
    props:{
      task:{Object,
        required:true,
      }
    },
    name: "TaskItem.vue"
  }
</script>

<style scoped>
    

</style>
