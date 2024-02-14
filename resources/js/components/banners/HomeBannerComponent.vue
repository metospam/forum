<script>

import {defineComponent} from "vue";
import CommunityCreateComponent from "../communities/CommunityCreateComponent.vue";

export default defineComponent({
  components: {CommunityCreateComponent},

  methods: {
    openPopup(){
      this.$refs.popup.popupIsOpened = true;
    }
  }
})
</script>

<template>
  <div class="home">
    <div class="home__background"></div>
    <div class="home__main">
      <div class="home__main-heading">
        <img src="../../../images/snoo-home@2x.png" alt="Logo">
        <span>Home</span>
      </div>

      <p class="home__main-text">
        Your personal Reddit frontpage. Come here to check in with your favorite communities.
      </p>
    </div>
    <hr>
    <div class="home__actions">
      <a href="/submit" class="home__create-post">
        Create Post
      </a>
      <span class="home__create-community" @click="openPopup">
        Create Community
      </span>
    </div>
  </div>
  <CommunityCreateComponent ref="popup"/>
</template>

<style scoped>
.home {
  border: 1px solid #474748;
  height: fit-content;
  position: sticky;
  top: 15px;
  background-color: #1A1A1B;
  border-radius: 4px;
  padding: 12px;
  grid-column: 2;
  grid-row: 1;
}

.home__background {
  height: 34px;
  border-radius: 3px 3px 0 0;
  margin: -12px -12px 10px;
  background-image: url(../../../images/home-banner@2x.png);
  background-position-y: center;
  background-position-x: center;
  background-repeat: no-repeat;
  background-size: cover;
}

.home__main {
  position: relative;
}

.home__main-heading {
  display: flex;
  align-items: center;
  column-gap: 10px;
  margin-bottom: 8px;
}

.home__main-heading img {
  width: 40px;
  height: 68px;
  margin-top: -23px;
}

.home__main-heading span {
  font-size: 16px;
  line-height: 20px;
  display: inline-block;
  color: #D7DADC;
}

.home__main-text {
  font-size: 14px;
  line-height: 21px;
  font-weight: 400;
  word-wrap: break-word;
  color: #D7DADC;
}

hr {
  height: 1px;
  margin: 16px 0;
  background-color: #343536;
}

.home__actions {
  display: flex;
  flex-direction: column;
  row-gap: 12px;
}

.home__create-community,
.home__create-post {
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: Noto Sans, Arial, sans-serif;
  font-size: 14px;
  font-weight: 700;
  letter-spacing: unset;
  line-height: 17px;
  text-transform: unset;
  min-height: 32px;
  min-width: 32px;
  padding: 4px 16px;
  border-radius: 9999px;
  cursor: pointer;
}

.home__create-post {
  background-color: #D7DADC;
  color: #1A1A1B;
}

.home__create-community:hover,
.home__create-post:hover {
  opacity: .8;
}

.home__create-community {
  color: #D7DADC;
  border: 1px solid #D7DADC;
}

</style>
