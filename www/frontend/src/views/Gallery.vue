<template>
    <div class="container center-block">
        <UploadImages/>
    </div>
</template>

<script>
  import UploadImages from '@/components/UploadImages'
  import {mapGetters, mapActions} from 'vuex';

  export default {
    name: "Images",
    components: {
      UploadImages,
    },

  }
</script>

<style scoped>

</style>
