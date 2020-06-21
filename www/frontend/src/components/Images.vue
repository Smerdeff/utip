<template>
    <div v-for="file in IMAGES" :key="file.id">
        <ImageBlock v-bind:file="image"/>
    </div>
</template>

<script>
  import ImageBlock from '@/components/ImageBlock'
  import {mapGetters, mapActions} from 'vuex';

  export default {
    name: "Images",
    computed: mapGetters(['IMAGES']),
    methods: mapActions(['READ_IMAGES']),
    async mounted() {
      this.READ_IMAGES();
    },
    components: {
      ImageBlock,
    },
  }
</script>

<style scoped>

</style>
