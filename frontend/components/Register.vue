<template>
    <div class="d-flex justify-center align-center">
        <div class="form">

            <v-sheet width="600" class="align-self-center">
                <h1>{{ $t('register.title') }}</h1>
                <v-form v-model="isFormValid" @submit.prevent>
                    <v-row>
                        <v-col cols="12" md="6">
                            <v-text-field v-model="name" :label="$t('register.name')" :rules="[required]"></v-text-field>
                        </v-col>
                        <v-col cols="12" md="6">
                            <v-text-field v-model="email" :label="$t('register.email')" :rules="[required, validMail]"
                                required></v-text-field>
                        </v-col>
                    </v-row>

                    <v-row>
                        <v-col cols="12" md="6">
                            <v-text-field :append-inner-icon="visible ? 'mdi-eye-off' : 'mdi-eye'"
                                :type="visible ? 'text' : 'password'" v-model="password" :label="$t('register.password')"
                                @click:append-inner="visible = !visible" :rules="[required, min6, validPassword]"
                                required></v-text-field>
                        </v-col>
                        <v-col cols="12" md="6">
                            <v-text-field :append-inner-icon="visibler ? 'mdi-eye-off' : 'mdi-eye'"
                                :type="visibler ? 'text' : 'password'" v-model="repeatpassword"
                                :label="$t('register.password2')" @click:append-inner="visibler = !visibler"
                                :rules="[required, matchingPasswords]" required></v-text-field>
                        </v-col>
                    </v-row>
                    <v-btn type="submit" @click="register()">{{ $t('register.title') }}</v-btn>

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
            name: '',
            email: '',
            password: '',
            repeatpassword: '',
            visible: false,
            visibler: false,
            isFormValid: false
        }
    },
    computed: {

    },
    methods: {
        required: function (value) {
            if (value) {
                return true;
            } else {
                return this.$t('validation.required');
            }
        },
        min6: function (value) {
            if (value.length >= 6) {
                return true;
            } else {
                return this.$t('validation.minLength');
            }
        },
        validPassword: function () {
            if (/.*\d.*/.test(this.password)) {
                return true;
            } else {
                return this.$t('validation.mustContainDigit');
            }
        },
        matchingPasswords: function () {
            if (this.password === this.repeatpassword) {
                return true;
            } else {
                return this.$t('validation.passwordsDontMatch');
            }
        },
        validMail: function () {
            if (/^(([^<>()[\]\\.,;:\s@']+(\.[^<>()\\[\]\\.,;:\s@']+)*)|('.+'))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(this.email)) {
                return true;
            } else {
                return this.$t('validation.invalidMail');
            }
        },
        register() {
            if (this.isFormValid) {
                try {
                    axios.post(import.meta.env.VITE_URL + '/api/account/register', {
                        name: this.name,
                        email: this.email,
                        password: this.password,

                    }).then((response) => {
                        console.log(response)

                        sessionStorage.setItem('token', response.data.token)
                        sessionStorage.setItem('role', response.data.role)
                        this.$router.push("/")
                        this.$store.dispatch('login', [response.data.token, response.data.role])

                    })
                } catch (e) {
                    console.log(e)
                }
            }
        }
    },
}
</script>

