<template>
    <div>
        <h2>Edit views</h2>
<!--        <TaskEdit/>-->
    </div>
</template>

<script>
  import TaskEdit from '@/components/TaskEdit'

  export default {
    name: "TaskForm",
    props: ['task'],
    components: {TaskEdit},
  }

</script>

<style scoped>

</style>
