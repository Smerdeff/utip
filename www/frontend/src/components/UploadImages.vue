<template>
    <div>
        <b-input-group prepend="Upload" class="mt-3">
            <b-form-file
                    v-model="files"
                    ref="file-input"
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
            <b-input-group-append>
                <b-button @click="clear" variant="outline-success">Clear</b-button>
                <b-button @click="upload" variant="info">Upload</b-button>
            </b-input-group-append>
        </b-input-group>
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
        // this.$store.dispatch('READ_IMAGES')
      },
      clear() {
        this.$refs['file-input'].reset();
        this.$store.dispatch('CLEAR_FILES')
      },
    },
    watch: {
      files: function (val) {
        this.$store.dispatch('UPDATE_FILES', this.files)
      },

    },
    computed: mapGetters(['FILES']),
    components: {
      UploadImageBlock,
    },
  }
</script>

<style scoped>

</style>
