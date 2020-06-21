<template>
    <div>
        <div>
            <b-img v-on:click="checked=!checked" v-bind:class="(checked)?'':'img_dark'" thumbnail fluid
                   :src="imageData"></b-img>
        </div>

        <!--        <div>-->
        <!--            <b-form-checkbox v-model="checked" name="check-button" switch>-->
        <!--            </b-form-checkbox>-->
        <!--        </div>-->
    </div>
</template>

<script>
  export default {
    name: "UploadImageBlock",
    data() {
      return {
        imageData: "",
        checked: true,
      }
    },
    props: ['image'],
    mounted: function () {
      this.loadimage() //method1 will execute at pageload
    },
    methods: {
      loadimage: function () {
      },
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
