<template>

    <div>
        <b-navbar toggleable="lg" type="dark" variant="info">
            <b-navbar-brand href="#">Gallery</b-navbar-brand>

            <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

            <b-collapse id="nav-collapse" is-nav>
                <b-navbar-nav>
                    <b-nav-item href="#" @click="ADD_MODE">Add</b-nav-item>
                    <b-nav-item href="#" @click="SELECT_MODE">Delete</b-nav-item>
<!--                    <b-nav-item href="#" v-if="IS_SELECT_MODE" @click="DESTROY_SELECTED_IMAGES"  variant="danger">Delete seleted</b-nav-item>-->


                </b-navbar-nav>
                <!--                    <b-button v-if="IS_SELECT_MODE" @click="DESTROY_SELECTED_IMAGES"  variant="danger" class="mr-2">Delete selected</b-button>-->
                <!-- Right aligned nav items -->
                <b-navbar-nav class="ml-auto">
                    <b-nav-form>
                        <b-form-input size="sm" class="mr-sm-2" placeholder="Search" v-model="search"></b-form-input>
                        <b-button size="sm" class="my-2 my-sm-0"  @click="READ_IMAGES">Search</b-button>
                    </b-nav-form>

                    <b-nav-item-dropdown right>
                        <!-- Using 'button-content' slot -->
                        <template v-slot:button-content>
                            <em>{{USER.username}}</em>
                        </template>
                        <b-dropdown-item href="#">Profile</b-dropdown-item>
                        <b-dropdown-item href="#" @click="LOGOUT">Sign Out</b-dropdown-item>
                    </b-nav-item-dropdown>
                </b-navbar-nav>
            </b-collapse>
        </b-navbar>
    </div>

</template>

<script>
  import {mapActions, mapGetters} from "vuex";

  export default {
    name: "Top",
    data() {
      return {
        search: '',
      }
    },
    computed: mapGetters(['isLoggedIn', 'USER', 'SEARCH' ]),
    methods: mapActions(['LOGOUT', 'TOKEN_LOGIN', 'READ_IMAGES', 'UPDATE_SEARCH', 'SELECT_MODE', 'DESTROY_SELECTED_IMAGES', 'ADD_MODE']),
    mounted() {
      this.TOKEN_LOGIN();
    },
    watch: {
      search: function (val) {
        this.$store.dispatch('UPDATE_SEARCH', val)
      }
    },
    components: {
    },
  }
</script>

<style scoped>

</style>
