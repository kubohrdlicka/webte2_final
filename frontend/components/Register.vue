<template>
	<div class="d-flex justify-center align-center">
		<div class="v-col-12 v-col-md-7 v-col-lg-5">
			<v-form v-model="isFormValid" @submit.prevent>
				<v-card flat>
					<v-card-title class="pt-4 pb-3">{{ $t('register.title') }}</v-card-title>
					<v-divider class="pb-4" />

					<div v-if="error" class="mx-4 d-flex justify-center pb-4">
            <v-chip color="error" variant="outlined" prepend-icon="mdi-alert-circle-outline">{{ error }}</v-chip>
          </div>

					<div class="d-flex flex-wrap">
						<div class="v-col-12 v-col-md-6 py-1">
							<v-text-field color="primary" v-model="name" :label="$t('register.name')"
								:rules="[required]"></v-text-field>
						</div>
						<div class="v-col-12 v-col-md-6 py-1">
							<v-text-field color="primary" v-model="surname" :label="$t('register.surname')"
								:rules="[required]"></v-text-field>
						</div>
						<div class="v-col-12 py-1">
							<v-text-field color="primary" v-model="email" :label="$t('register.email')"
								:rules="[required, validMail]"></v-text-field>
						</div>
					</div>

					<div class="d-flex flex-wrap">
						<div class="v-col-12 v-col-md-6 py-1">
							<v-text-field color="primary" :append-inner-icon="visible ? 'mdi-eye-off' : 'mdi-eye'"
								:type="visible ? 'text' : 'password'" v-model="password" :label="$t('register.password')"
								@click:append-inner="visible = !visible" :rules="[required, min6, validPassword]"></v-text-field>
						</div>
						<div class="v-col-12 v-col-md-6 py-1">
							<v-text-field color="primary" :append-inner-icon="visibler ? 'mdi-eye-off' : 'mdi-eye'"
								:type="visibler ? 'text' : 'password'" v-model="repeatpassword" :label="$t('register.password2')"
								@click:append-inner="visibler = !visibler" :rules="[required, matchingPasswords]"></v-text-field>
						</div>
					</div>

					<div class="my-4 v-col-12 d-flex justify-center">
						<v-btn type="submit" color="primary" @click="register()">{{ $t('register.action') }}</v-btn>
					</div>
				</v-card>
			</v-form>

			<div class="d-flex justify-center mt-4">
				<router-link class="hk-login-link text-caption" to="/login">{{ $t('links.alreadyHaveAccount') }}</router-link>
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
			name: '',
			surname: '',
			email: '',
			password: '',
			repeatpassword: '',
			visible: false,
			visibler: false,
			isFormValid: false,
			error: '',
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
			if (this.password != this.repeatpassword) {
				// this.$store.dispatch('showSnackbar', this.$t('register.passwordsNotMatch'))
				// alert("bad");
				return
			}

			if (this.isFormValid) {
				axios.post(import.meta.env.VITE_URL + '/api/account/register', {
					name: this.name,
					surname: this.surname,
					email: this.email,
					password: this.password,

				}).then((response) => {
					console.log(response)

					sessionStorage.setItem('token', response.data.token)
					sessionStorage.setItem('role', response.data.role)
					this.$router.push("/")
					this.$store.dispatch('login', [response.data.token, response.data.role])

				}).catch(e => {
					this.error = this.$t('register.fail')
				})
			}
		},
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
