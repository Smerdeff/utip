<template>
    <div>
        <h2>Vue Gallery example</h2>
        <ul>
            <li>
                <router-link to="/gallery">Gallery</router-link>
            </li>
            <li>
                <router-link to="/register">Register</router-link>
            </li>
        </ul>
    </div>

</template>

<script>
  import Login from '@/components/Login'
  import Register from '@/components/Register'
  import {mapGetters, mapActions} from 'vuex'

  export default {
    name: "Home",
    computed: mapGetters(['isLoggedIn']),
    methods: mapActions(['LOGOUT']),
    components: {
      Login,
      Register
    }
  }
</script>

<style scoped>

</style>
