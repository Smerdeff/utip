<template>
    <div>
        <!--               v-bind:class="(checked)?'':'img_dark'"-->
        <b-modal v-model="modalShow"
                 @ok="handleOk">
            <ImageForm v-bind:image="image"/>

        </b-modal>
        <!--               v-b-tooltip.hover -->
        <b-img v-on:click="imageClick"
               :src="thumbnail_path"
               :alt="image.title"
               :title="image.title"
               thumbnail fluid
        >
        </b-img>
        <p v-if="is_select_mode "><b-form-checkbox size="lg" v-model="selected"></b-form-checkbox></p>
    </div>
</template>

<script>
  import ImageForm from '@/components/ImageForm'
  import {mapGetters, mapActions} from 'vuex';

  export default {
    name: "ImageBlock",
    data() {
      return {
        imageData: "",
        checked: true,
        currentImage: null,
        modalShow: false,
        selected: false,
      }
    },
    props: ['image', 'is_select_mode'],
    mounted: function () {
      this.loadimage()
    },
    computed: {
      thumbnail_path: function () {
        return "http://localhost/api/thumbnail/" + this.image.file_name
      }

    },
    methods: {
      loadimage: function () {
      },
      image_click: function () {
        console.log(this.image.id)
      },
      handleOk(bvModalEvt) {
        this.$store.dispatch('UPDATE_IMAGES', this.image)
      },
      imageClick(bvModalEvt) {
        if (this.is_select_mode) {
          this.selected = !this.selected
        } else {
          this.modalShow = !this.modalShow
        }
      },
    },
    watch: {
      selected: function (val) {
        // console.log(this.image.id, val )
        this.$store.dispatch('UPDATE_SELECTED', {id:this.image.id, selected:val})
      }

    },
    components: {
      ImageForm,
    },

  }
</script>

<style scoped>
    .img_dark {
        opacity: 0.5;
        -moz-opacity: 0.5;
        filter: alpha(opacity=50) black;
        -khtml-opacity: 0.5;
        background-color: #000;
    }
</style>
