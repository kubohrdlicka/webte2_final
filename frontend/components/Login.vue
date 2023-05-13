<template>
  <div class="d-flex justify-center align-center">
    <div class="v-col-12 v-col-sm-8 v-col-md-4 v-col-lg-2">
      <v-form v-model="isFormValid" @submit.prevent>
        <v-card flat>
          <v-card-title class="pt-4 pb-3">{{ $t('login.title') }}</v-card-title>
          <v-divider class="pb-4" />

          <div v-if="error" class="mx-4 d-flex justify-center">
            <v-chip color="error" variant="outlined" prepend-icon="mdi-alert-circle-outline">{{ error }}</v-chip>
          </div>

          <div class="v-col-12">
            <v-text-field color="primary" v-model="email" :label="$t('register.email')"
              :rules="[required]"></v-text-field>

            <v-text-field color="primary" :append-inner-icon="visible ? 'mdi-eye-off' : 'mdi-eye'"
              :type="visible ? 'text' : 'password'" v-model="password" :label="$t('register.password')"
              @click:append-inner="visible = !visible" :rules="[required]"></v-text-field>
          </div>

          <div class="my-4 v-col-12 d-flex justify-center">
            <v-btn type="submit" color="primary" @click="logIn()">{{ $t('login.action') }}</v-btn>
          </div>
        </v-card>
      </v-form>

      <div class="d-flex justify-center mt-4">
        <router-link class="hk-login-link text-caption" to="/register">{{ $t('links.noAccount') }}</router-link>
      </div>
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
      visible: false,
      isFormValid: false,
      error: null,
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
    logIn() {
      if (this.isFormValid) {
        axios.post(import.meta.env.VITE_URL + '/api/account/login', {
          email: this.email,
          password: this.password
        }).then((response) => {
          this.error = null
          sessionStorage.setItem('token', response.data.token)
          sessionStorage.setItem('role', response.data.role)
          this.$store.dispatch('login', { token: response.data.token, role: response.data.role })
          this.$router.push("/")

        }).catch(e => {
          this.error = this.$t('login.fail')
        })
      }
    }
  }
}
</script>

<style lang="scss" scoped>
.hk-login-link {
  text-decoration: none;
	color: rgb(var(--v-theme-secondary));
  transition: all .2s;

  &:hover {
    transition: all .2s;
    color: rgb(var(--v-theme-surface-variant));;
  }
}
</style>
