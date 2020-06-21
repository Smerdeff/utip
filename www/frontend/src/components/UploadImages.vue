<template>
    <div>
        <b-form-file
                v-model="files"
                :state="Boolean(files)"
                placeholder="Choose a file or drop it here..."
                multiple accept="image/*"
        >
            <template slot="file-name" slot-scope="{ names }">
                <b-badge variant="dark">{{ names[0] }}</b-badge>
                <b-badge v-if="names.length > 1" variant="dark" class="ml-1">
                    + {{ names.length - 1 }} More FILES
                </b-badge>
            </template>
        </b-form-file>
        <b-button @click="upload" class="mr-2">Upload</b-button>
        <b-button @click="clear">Clear</b-button>

        <b-container fluid class="p-4 bg-dark">
            <b-row>
                <b-col v-for="file in FILES" :key="file.name">
                    <UploadImageBlock v-bind:file="file"/>
                </b-col>
            </b-row>
        </b-container>

    </div>
</template>

<script>
  import UploadImageBlock from '@/components/UploadImageBlock'
  import {mapGetters, mapActions} from 'vuex';

  export default {
    name: "UploadImages",
    data() {
      return {
        files: []
      }
    },
    methods: {
      upload() {
        this.FILES.forEach((file, index) => {
          this.$store.dispatch('POST_FILE', file)
        })
      },
      clear() {
        this.$store.dispatch('CLEAR_FILES')
      },
    },
    watch: {
      files: function (val) {
        this.$store.dispatch('UPDATE_FILES', this.files)
      },

    },

    computed: mapGetters(['FILES']),
    // methods: mapActions(['SET_FILES']),

    components: {
      UploadImageBlock,
    },
  }
</script>

<style scoped>

</style>
