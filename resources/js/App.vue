<script>

import HeaderComponent from "./components/HeaderComponent.vue";
import {defineComponent} from "vue";
import MainComponent from "./components/content/MainComponent.vue";
import AuthService from "./services/AuthService";

export default defineComponent({
  components: {MainComponent, HeaderComponent},

  data() {
    return {
      user: {},
    }
  },

  methods: {
    async checkIsAuthorized() {
      if (localStorage.getItem('access_token')) {
        await AuthService.refreshToken().then(response => {
          if (response.status === 200 && response.data.access_token) {
            localStorage.setItem('access_token', response.data.access_token);

            AuthService.getUserData().then(response => {
              if (response.status === 200 && response.data.data) {
                this.user = Object.freeze(response.data.data);
              }
            }).catch(error => {
              this.user = {};
            });
          }
        }).catch(error => {
          localStorage.removeItem('access_token');
        });
      }
    },

    openPopup() {
      this.$refs.header.openPopup();
    },
  },

  mounted() {
    this.checkIsAuthorized()
  }
})


</script>

<template>
  <HeaderComponent :user="user" ref="header"/>
  <router-view :user="user" v-cloak/>
</template>

<style>

* {
  padding: 0px;
  margin: 0px;
  border: 0px;
}

*,
*:before,
*:after {
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
}

:focus,
:active {
  outline: none;
}

a:focus,
a:active {
  outline: none;
}

aside,
nav,
footer,
header,
section {
  display: block;
}

body {
  background-color: var(--color-neutral-background);
  font-family: var(--font-sans);
  line-height: 150%;
  font-weight: 400;
  -ms-text-size-adjust: 100%;
  -moz-text-size-adjust: 100%;
  -webkit-text-size-adjust: 100%;
  color: var(--color-neutral-content-strong);
}

body.lock {
  overflow-y: hidden;
}

:root {
  --color-action-downvote: #6A5CFF;
  --color-action-upvote: #D93A00;
  --color-neutral-background-hover: #131F23;
  --color-secondary-weak: #82959B;
  --color-white: #fff;
  --color-neutral-background-weak: #04090A;
  --color-neutral-content-weak: #82959B;
  --color-neutral-content: #B8C5C9;
  --color-danger-content: #FF6E80;
  --color-neutral-background: #0B1416;
  --color-neutral-content-strong: #F2F4F5;
  --color-secondary-background: #1A282D;
  --font-sans: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', sans-serif
}

input,
button,
textarea {
  font-family: var(--font-sans);
}

input::-ms-clear {
  display: none;
}

button {
  cursor: pointer;
}

button::-moz-focus-inner {
  padding: 0;
  border: 0;
}

a,
a:visited {
  font-family: var(--font-sans);
  text-decoration: none;
}

a:hover {
  text-decoration: none;
}

ul li,
ul {
  list-style: none;
}

img {
  vertical-align: top;
  width: 100%;
}

h1,
h2,
h3,
h4,
h5,
h6 {
  font-weight: inherit;
  font-size: inherit;
}

input {
  -webkit-appearance: none;
}

input[type="number"]::-webkit-outer-spin-button,
input[type="number"]::-webkit-inner-spin-button {
  -webkit-appearance: none;
}

input[type='number'],
input[type="number"]:hover,
input[type="number"]:focus {
  -webkit-appearance: none;
  appearance: none;
  -moz-appearance: textfield;
}

.container {
  max-width: 1400px;
  padding-inline: 20px;
  margin-inline: auto;
}

.container-max {
  max-width: 1880px;
}

.btn {
  padding-inline: 0.75rem;
  color: #F2F4F5;
  font-weight: 500;
  background-color: #D93A00;
  align-items: center;
  display: flex;
  justify-content: center;
  border-radius: 20px;
  cursor: pointer;
}

.btn:hover {
  background-color: #962900;
}

.background-overlay {
  background: rgb(26, 26, 27);
  width: 100%;
  height: 100%;
  position: fixed;
  top: 0;
  left: 0;
  opacity: 0;
  visibility: hidden;
  z-index: 999;
}

.separator {
  font-size: .75rem;
  line-height: 1rem;
  color: var(--color-neutral-content-weak);
}

</style>


