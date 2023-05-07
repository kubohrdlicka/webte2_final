<template>
    <div class="d-flex justify-center align-center">
        <div class="form">

            <v-sheet width="300" class="align-self-center">
                <h1>{{ $t('login.title') }}</h1>
                <v-form fast-fail @submit.prevent>
                    <v-text-field v-model="email" label="E-mail" required></v-text-field>

                    <v-text-field :append-inner-icon="visible ? 'mdi-eye-off' : 'mdi-eye'"
                        :type="visible ? 'text' : 'password'" v-model="password" :label="$t('login.password')"
                        @click:append-inner="visible = !visible" :rules="[required]"></v-text-field>

                    <v-btn type="submit" @click="logIn" block class="mt-2">{{ $t('login.title') }}</v-btn>

                </v-form>
            </v-sheet>
        </div>
    </div>
</template>

<script>
import axios from 'axios'

export default {
    name: 'Login',
    data() {
        return {
            email: '',
            password: '',
            visible: false
        }
    },
    computed: {

    },
    methods: {
        required: function (value) {
            if (value) {
                return true;
            } else {
                return 'This field is required.';
            }
        },
        logIn() {
            try {
                axios.post(import.meta.env.VITE_URL + '/api/account/login', {
                    email: this.email,
                    password: this.password
                }).then((response) => {
                    sessionStorage.setItem('token', response.data.token)
                    sessionStorage.setItem('role', response.data.role)
                    this.$store.dispatch('login', {token: response.data.token, role: response.data.role})
                    this.$router.push("/")

                })
            } catch (e) {
                console.log(e)
            }
        }
    }
}


</script>