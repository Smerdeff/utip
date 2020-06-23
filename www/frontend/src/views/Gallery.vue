<template>
    <div class="container center-block">
        <UploadImages/>
        <br>
        <Images/>
    </div>
</template>

<script>
  import UploadImages from '@/components/UploadImages'
  import Images from '@/components/Images'
  // import {mapGetters, mapActions} from 'vuex';

  export default {
    name: "Gallery",
    components: {
      UploadImages,
      Images,
    },

  }
</script>

<style scoped>

</style>
