<script>

import LogInComponent from "./LogInComponent.vue";
import SignUpComponent from "./SignUpComponent.vue";

export default {
  components: {SignUpComponent, LogInComponent},

  props: ['popupIsOpened', 'closePopup'],

  data() {
    return {
      isLogIn: true,
      incorrectData: false,
    }
  },

  methods:{
    switchForm(){
      this.isLogIn = !this.isLogIn;
    },
  }
}

</script>

<template>
  <div class="popup" :class="popupIsOpened ? 'active' : ''">
    <div class="background-overlay" @click="closePopup"></div>
    <div class="popup__wrapper">
      <div class="popup__header">
        <div class="popup__close" id="login-close" @click="closePopup">
          <svg rpl="" fill="currentColor" height="16" icon-name="close-outline" viewBox="0 0 20 20" width="16"
               xmlns="http://www.w3.org/2000/svg">
            <path
                d="m18.442 2.442-.884-.884L10 9.116 2.442 1.558l-.884.884L9.116 10l-7.558 7.558.884.884L10 10.884l7.558 7.558.884-.884L10.884 10l7.558-7.558Z"></path>
          </svg>
        </div>
      </div>
      <LogInComponent :switchForm="switchForm"
                      v-if="isLogIn" />
      <SignUpComponent :switchForm="switchForm"
                       v-else />
    </div>
  </div>
</template>

<style>
.popup__wrapper {
  position: fixed;
  left: 50%;
  top: 50%;
  transform: translate(-50%, -50%);
  height: 100%;
  width: 100%;
  max-width: 528px;
  background-color: var(--color-neutral-background);
  z-index: 1002;
  display: flex;
  flex-direction: column;
  max-height: 620px;
  border-radius: 20px;
  opacity: 0;
  visibility: hidden;
  transition: .3s;
}

.popup.active .background-overlay {
  opacity: .5;
  visibility: visible;
}

.popup.active .popup__wrapper{
  opacity: 1;
  visibility: visible;
}

.popup__header {
  padding: 1.5rem 24px 0.5rem;
  display: flex;
  align-items: center;
  justify-content: flex-end;
}

.popup__close {
  cursor: pointer;
  width: 32px;
  height: 32px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: var(--color-secondary-background);
}

.popup__close path {
  fill: var(--color-neutral-content-strong);
}

.popup__close:hover {
  background-color: #203036;
}

.popup__title {
  font-size: 24px;
  font-weight: 700;
}

.popup__footer,
.popup__body {
  padding-inline: 80px;
}

.popup__body {
  height: 100%;
  overflow-y: auto;
}

.popup__form {
  display: flex;
  flex-direction: column;
  row-gap: 20px;
  width: 100%;
}

.popup__form input {
  width: 100%;
  height: 56px;
  border-radius: 20px;
  padding-inline: 1rem;
  background-color: var(--color-secondary-background);
  color: var(--color-neutral-content-strong);
  font-size: 16px;
}

.popup__form input.error {
  box-shadow: 0 0 0 0.125rem var(--color-danger-content);
}

.popup__input {
  position: relative;
}

.popup__text {
  font-size: 14px;
  margin-block: 8px;
  line-height: 140%;
}

.popup__footer {
  height: 96px;
}

.popup__footer .btn {
  height: 50px;
}

.popup__error {
  color: var(--color-danger-content);
  font-size: 12px;
  margin-top: -20px;
  margin-left: 15px;
}

.popup__redirect{
  font-size: 14px;
  margin-top: 1em;
  margin-bottom: 20px;
}

.popup__redirect span{
  color: #629FFF;
  cursor: pointer;
}
</style>
