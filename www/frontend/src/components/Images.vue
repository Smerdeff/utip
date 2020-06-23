<template>
    <div>
        <b-button @click="SELECT_MODE" class="mr-2">Select Mode</b-button>
        <b-button v-if="IS_SELECT_MODE" @click="DESTROY_SELECTED_IMAGES"  variant="danger" class="mr-2">Delete selected</b-button>

        <b-input-group prepend="Search" class="mt-3">
        <b-form-input id="search" v-model="search" placeholder="Search"></b-form-input>
            <b-input-group-append>
                <b-button variant="outline-success" @click="search=null">Clear</b-button>
                <b-button variant="info" @click="READ_IMAGES" >Refresh</b-button>
            </b-input-group-append>
        </b-input-group>
        <br>
        <div class="row">
            <div class='col-xs-12 col-sm-4 col-md-3 col-lg-3' v-for="image in IMAGES " :key="image.id">
                <ImageBlock :image="image" :is_select_mode="IS_SELECT_MODE" />
            </div>
        </div>
    </div>
</template>

<script>
  import ImageBlock from '@/components/ImageBlock'
  import {mapGetters, mapActions} from 'vuex'

  export default {
    name: "Images",
    data() {
      return {
        search: '',
      }
    },
    computed: mapGetters(['IMAGES', 'IS_SELECT_MODE', 'SEARCH']),
    methods: mapActions(['READ_IMAGES', 'SELECT_MODE', 'DESTROY_SELECTED_IMAGES']),
    async mounted() {
      this.READ_IMAGES();
    },
    watch:{
      search: function (val) {
        this.$store.dispatch('UPDATE_SEARCH', val)
      }
    },

    components: {
      ImageBlock,
    },
  }
</script>

<style scoped>

</style>
