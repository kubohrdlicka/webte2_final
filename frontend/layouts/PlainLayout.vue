<template>
    
    <div class="d-flex justify-center align-center content">
        <div class="form">
            
            <v-sheet width="300" class="align-self-center">
                <h1>{{ $t('login.title') }}</h1>
                <v-form fast-fail @submit.prevent>
                    <v-text-field v-model="email" label="E-mail" required></v-text-field>
                    
                    <v-text-field :append-inner-icon="visible ? 'mdi-eye-off' : 'mdi-eye'" :type="visible ? 'text' : 'password'"
                    v-model="password" :label="$t('login.password')"  @click:append-inner="visible = !visible"
                    required></v-text-field>
                    
                    <v-btn type="submit" @click="logIn" block class="mt-2">{{$t('login.title')}}</v-btn>
                    
                </v-form>
            </v-sheet>
        </div>
    </div>
    <div class="info">
        <ChangeLanguage></ChangeLanguage>
        <ChangeTheme></ChangeTheme>
    </div>
</template>

<script>
import ChangeTheme from '../components/ChangeTheme.vue'
import ChangeLanguage from '../components/ChangeLanguage.vue'
import axios from 'axios'

export default {
    name: 'LoginLayout',
    components: {
        ChangeTheme,
        ChangeLanguage
    },
    data(){
        return{
            email: '',
            password: '',
            visible: false
        }
    },
    computed: {

    },
    methods: {
        logIn(){
            try{
                axios.post(import.meta.env.VITE_URL+'/api/account/login', {
                    email: this.email,
                    password: this.password
                }).then((response) => {
                    console.log(response)
                    
                        sessionStorage.setItem('token', response.data.token)
                        sessionStorage.setItem('role', response.data.role)
                        this.$router.push("/")
                        this.$store.dispatch('login', [ response.data.token, response.data.role])
                    
                })
            }catch(e){
                console.log(e)
            }
        }

    }
}

</script>

<style scoped>
.info{
    height: 50px;
    text-align: end;
}

.content{
    height: calc(100vh - 50px);
    /* margin-bottom: 50px; */
    }
</style>