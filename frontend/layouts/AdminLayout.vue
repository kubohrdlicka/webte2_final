<template>
    <AdminNavBar></AdminNavBar>
    <router-view></router-view>

</template>

<script>
import axios from 'axios'
import AdminNavBar from '../components/AdminNavBar.vue'

export default{
    name: 'AdminLayout',
    components: {
        AdminNavBar
    },
}



</script>