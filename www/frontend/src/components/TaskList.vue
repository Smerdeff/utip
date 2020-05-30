<template>
    <ul>
        <TaskItem
                v-for="task in tasks.data"
                v-bind:task="task"
        />

    </ul>
</template>

<script>
  import TaskItem from "./TaskItem";

  export default {
    props: ['tasks'],
    components: {TaskItem}
  }
</script>
