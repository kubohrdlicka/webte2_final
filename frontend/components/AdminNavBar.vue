<template>
    <v-toolbar class="toolbar">

        <v-toolbar-title>Finalne Zadanie - ADMIN</v-toolbar-title>

        <v-toolbar-items>

            <v-btn @click="logOut">
                <v-icon icon="mdi-logout"></v-icon>
            </v-btn>


        </v-toolbar-items>
    </v-toolbar>
</template>

<script>
import axios from 'axios'

export default {
    name: 'Toolbar',
    computed: {

    },
    methods: {
        async logOut() {
            sessionStorage.clear()

            try {
                await axios.post(import.meta.env.VITE_URL + '/api/account/logout', { headers: { Authorization: 'Bearer ' + sessionStorage.getItem('token') } }).then((response) => {
                    sessionStorage.clear()
                    this.$store.dispatch('logOut')
                    this.$router.push('/login')
                })

            } catch (e) {
                console.log(e)
            }

        }
    }
}
</script>

<style>
.toolbar {
    margin-bottom: 1rem;
}

.img {
    /* width: 2rem; */
    height: 3rem;
    /* margin-left: 2rem; */
}
</style>
