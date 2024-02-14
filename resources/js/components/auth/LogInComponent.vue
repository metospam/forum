<script>
import AuthService from "../../services/AuthService";

export default {
    props: [
        'incorrectData',
        'switchForm'
    ],

    emits: [
        'setIncorrectData',
        'checkData'
    ],

    data() {
        return {
            email: '',
            password: '',
            errors: {
                email: false,
                password: false,
            },
            currentError: '',
        }
    },

    methods: {
        async login() {
            if (!this.email || !this.password) {
                this.errors.email = !this.validateEmail(this.email);
                this.errors.password = !this.password;

                return;
            }

            this.errors.email = false;
            this.errors.password = false;

            await AuthService.login(this.email, this.password)
                .then(response => {
                    if (response.status === 200 && response.data) {
                        const access_token = response.data.access_token;
                        localStorage.setItem('access_token', access_token)

                        window.location.reload();
                    }
                }).catch(error => {
                    if (error.response.status === 400) {
                        let errors = error.response.data;

                        for (const key in errors) {
                            if (errors.hasOwnProperty(key) && errors[key].length > 0) {
                                this.currentError = errors[key][0];
                                this.errors[key] = true;
                                break;
                            }
                        }
                    } else if (error.response.status === 401) {
                        this.currentError = 'Incorrect email or password';
                    }
                })
        },

        handleErrors() {
            this.errors.email = !this.validateEmail(this.email);
            this.errors.password = this.password.length < 8;
        },

        validateEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        },
    },
}
</script>

<template>
    <div class="popup__body">
        <h1 class="popup__title">Log In</h1>
        <p class="popup__text">
            By continuing, you agree to our User Agreement and acknowledge that you understand the Privacy Policy.
        </p>
        <form class="popup__form" @keydown.enter="login">
            <div class="popup__input">
                <input :class="{ 'error': errors.email }" type="text" v-model="email"
                       @input="handleErrors" placeholder="Email" autocomplete="email">
            </div>

            <div class="popup__input">
                <input :class="{ 'error': errors.password }" type="password" v-model="password"
                       @input="handleErrors" placeholder="Password" autocomplete="current-password">
            </div>

            <span class="popup__error">
                {{ currentError }}
            </span>
        </form>

        <div class="popup__redirect">
            New to Reddit? <span @click="switchForm">Sign up</span>
        </div>
    </div>
    <div class="popup__footer">
      <span class="btn" @click="login">
        Log In
      </span>
    </div>
</template>

