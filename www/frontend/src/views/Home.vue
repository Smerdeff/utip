<template>
    <div >
        <h2>Vue Gallery example</h2>
        <router-link to="/gallery">Gallery</router-link>
        <br>
        <span v-if="isLoggedIn"> <b-button @click="LOGOUT">Logout</b-button></span>
        <br>
        <Login/>
        <br>
        <Register/>
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
    components:{
      Login,
      Register
    }
  }
</script>

<style scoped>

</style>
