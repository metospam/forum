<script>

import CommunityService from "../../services/CommunityService";

export default {
  data(){
    return {
      name: '',
      popupIsOpened: false,
    }
  },

  methods: {
    async createCommunity(){
      await CommunityService.createCommunity(this.name).then(response => {
        if(response.status === 201 && response.data){
          let slug = response.data.slug;
          window.location.href = `../community/${slug}`;
        }
      }).catch(error => {
        console.log(error);
      })
    },

    closePopup(){
      this.popupIsOpened = false;
      document.body.classList.remove('lock');
    }
  }
}

</script>

<template>
  <div class="home-popup" :class="popupIsOpened ? 'active': ''">
    <div class="background-overlay" @click="closePopup"></div>
    <div class="home-popup__wrapper">
      <div class="home-popup__header">
        <span class="home-popup__title">Create a community</span>
        <svg @click="closePopup" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" class="_1P7Eow5rs9Xxm1uqMMEr2h">
          <polygon fill="inherit"
                   points="11.649 9.882 18.262 3.267 16.495 1.5 9.881 8.114 3.267 1.5 1.5 3.267 8.114 9.883 1.5 16.497 3.267 18.264 9.881 11.65 16.495 18.264 18.262 16.497"></polygon>
        </svg>
      </div>

      <div class="home-popup__body">
        <div class="community-form">
        <span class="community-form__name">
          Name
        </span>
          <p class="home-popup__text">Community names including capitalization cannot be changed.</p>
          <label for="name" hidden></label>
          <input type="text" id="name" name="name" v-model="name">
        </div>
      </div>
      <div class="home-popup__footer">
        <span class="cancel-action" @click="closePopup">Cancel</span>
        <span class="create-action" @click="createCommunity">Create Community</span>
      </div>
    </div>
  </div>
</template>

<style scoped>
  .home-popup__wrapper{
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    max-width: 512px;
    border-radius: 4px;
    max-height: 100%;
    padding: 16px;
    background-color: #1A1A1B;
    border: 1px solid #343536;
    width: 100%;
    opacity: 0;
    visibility: hidden;
    z-index: 1000;
  }

  .home-popup.active .home-popup__wrapper{
    opacity: 1;
    visibility: visible;
  }

  .home-popup.active .background-overlay{
    opacity: .5;
    visibility: visible;
  }

  .home-popup__header{
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: 1px solid #343536;
    margin-bottom: 16px;
    padding: 0 0 16px;
  }

  .home-popup__header svg{
    fill: #818384;
    width: 16px;
    height: 16px;
    cursor: pointer;
  }

  .home-popup__name,
  .home-popup__title{
    font-size: 16px;
    font-weight: 500;
    color: #D7DADC;
  }

  .home-popup__text{
    font-size: 12px;
    color: #818384;
  }

  .home-popup #name{
    margin-top: 12px;
    background-color: #1A1A1B;
    border: 1px solid #343536;
    margin-bottom: 8px;
    border-radius: 4px;
    max-height: 37px;
    padding-left: 12px;
    height: 48px;
    width: 100%;
    color: #D7DADC;
  }

  .home-popup__footer{
    padding: 16px;
    margin: 16px -16px -16px;
    background-color: #343536;
    justify-content: flex-end;
    display: flex;
  }

  .home-popup__footer .create-action{
    margin-left: 8px;
    border-radius: 9999px;
    background-color: #D7DADC;
    color: #1A1A1B;
    min-height: 32px;
    min-width: 32px;
    padding: 4px 16px;
    font-size: 14px;
    font-weight: 700;
    line-height: 17px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
  }

  .home-popup__footer .cancel-action{
    cursor: pointer;
    font-size: 14px;
    font-weight: 700;
    letter-spacing: unset;
    line-height: 17px;
    text-transform: unset;
    border: 1px solid #D7DADC;
    color: #D7DADC;
    padding: 4px 16px;
    border-radius: 9999px;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .home-popup__footer .create-action:hover,
  .home-popup__footer .cancel-action:hover{
      opacity: .8;
  }
</style>
