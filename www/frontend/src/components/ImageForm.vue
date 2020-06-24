<template>
    <div>
        <b-img :src="image_path"
               :alt="image.title"
               thumbnail fluid
        >
        </b-img>
        <b-form-input id="title" v-model="image.title" placeholder="Title"></b-form-input>
        <b-form-textarea id="description" v-model="image.description" placeholder="Description"></b-form-textarea>
    </div>
</template>

<script>
  export default {
    name: "ImageForm",
    data() {
      return {
        title: '',
        description: '',
      }
    },
    props: ['image'],
    computed: {
      image_path: function () {
        return "http://localhost/uploads/" + this.image.file_name
      }
    },
    mounted() {
      this.onload();
    },
    methods: {
      onload() {
        this.title = this.image.title;
        this.description = this.image.description;
        }
    },
  }
</script>

<style scoped>

</style>
