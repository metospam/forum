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
      username: '',
      email: '',
      password: '',
      password_confirmation: '',
    }
  },

  methods: {
    register() {
      AuthService.register(this.username, this.email, this.password, this.password_confirmation).then(response => {
        if (response.data) {
          const access_token = response.data.access_token;
          localStorage.setItem('access_token', access_token)

          window.location.reload();
        }
      }).catch(error => {
        this.$emit('setIncorrectData', true);
      })
    },

    checkData(event) {
      let inputValue = event.target.value;
      this.$emit('checkData', inputValue);
    },
  }
}
</script>

<template>
  <div class="popup__body">
    <h1 class="popup__title">Sign Up</h1>
    <p class="popup__text">
      By continuing, you agree to our User Agreement and acknowledge that you understand the Privacy Policy.
    </p>
    <form class="popup__form" @keydown.enter="register">
      <div class="popup__input">
        <input :class="incorrectData ? 'error' : ''" type="text" v-model="username"
               @input="checkData" placeholder="Username">
      </div>

      <div class="popup__input">
        <input :class="incorrectData ? 'error' : ''" type="text" v-model="email"
               @input="checkData" placeholder="Email">
      </div>

      <div class="popup__input">
        <input :class="incorrectData ? 'error' : ''" type="password" v-model="password"
               @input="checkData" placeholder="Password">
      </div>

      <div class="popup__input">
        <input :class="incorrectData ? 'error' : ''" type="password" v-model="password_confirmation"
               @input="checkData" placeholder="Confirm Password">
      </div>

      <template v-if="incorrectData">
        <span class="popup__error">incorrect data</span>
      </template>
    </form>

    <div class="popup__redirect">
      Already a redditor? <span @click="switchForm">Sign up</span>
    </div>
  </div>
  <div class="popup__footer">
      <span class="btn" @click="register">
        Sign Up
      </span>
  </div>
</template>

<style scoped>

</style>
