<template>
    <div>
        <div v-if="isLoggedIn" class="container center-block">
            <top/>
            <br>

            <div v-if="IS_ADD_MODE">
                <UploadImages/>
            </div>
            <br>
            <Images/>
        </div>
        <div v-else>
            <login/>
        </div>


    </div>
</template>

<script>
  import UploadImages from '@/components/UploadImages'
  import Images from '@/components/Images'
  import Login from '@/components/Login'
  import Top from '@/components/Top'
  import {mapGetters, mapActions} from 'vuex'
  import Axios from "axios";

  export default {
    name: "Gallery",
    computed: mapGetters(['isLoggedIn','IS_ADD_MODE']),
    components: {
      UploadImages,
      Images,
      Login,
      Top,
    },

  }
</script>

<style scoped>

</style>
