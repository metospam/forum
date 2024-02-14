<script>
import CommunityService from "../../services/CommunityService";

export default {

  props: ['user'],

  data() {
    return {
      description: '',
      image: null,
    }
  },

  methods:{
    setImage(e){
      let files = e.target.files || e.dataTransfer.files;
      if (!files.length)
        return;

      this.image = files[0];
      e.target.value = null;

      CommunityService.uploadAvatarToCommunity(this.$route.params.slug, this.image);
    },

    async updateCommunity(){
      await CommunityService.updateCommunity(this.$route.params.slug, this.description);
    }
  },
}

</script>

<template>
  <div class="profile">
    <div class="container">

      <div class="profile__header">
        <h1 class="profile__title">
          Customize community
        </h1>

        <a :href="`../../community/${this.$route.params.slug}`" class="profile__redirect">
          To community
        </a>
      </div>

      <h2 class="profile__sub-title">
        COMMUNITY INFORMATION
      </h2>

      <div class="field">
        <h3 class="field__title">Description</h3>
        <p class="field__text">
          Set an description.
        </p>
        <textarea class="field__input" @keyup.enter="updateCommunity" placeholder="Description (optional)" v-model="description"></textarea>
        <span class="field__help">
        {{ 200 - description.length }} Characters remaining
      </span>
      </div>
    </div>

    <h2 class="profile__sub-title">
      IMAGES
    </h2>

    <div class="field">
      <h3 class="field__title">Avatar and banner image</h3>
      <p class="field__text">
        Images must be .png or .jpg format
      </p>

      <div class="field__drop">
        <svg class="_3KHqxOxhEHArGV9xYKYedu" viewBox="0 0 36 36" version="1.1"><circle cx="18" cy="18" fill="#fff" r="17.5" stroke="inherit"></circle><path clip-rule="evenodd" d="m25.2 16.8001h-6v-6c0-.6624-.5364-1.2-1.2-1.2s-1.2.5376-1.2 1.2v6h-6c-.6636 0-1.20002.5376-1.20002 1.2s.53642 1.2 1.20002 1.2h6v6c0 .6624.5364 1.2 1.2 1.2s1.2-.5376 1.2-1.2v-6h6c.6636 0 1.2-.5376 1.2-1.2s-.5364-1.2-1.2-1.2z" fill="inherit" fill-rule="evenodd"></path></svg>
        <span class="field__drop-text">
        Drag and Drop or Upload <span style="font-weight: 700;">Avatar</span> Image
      </span>
      </div>
      <input class="field__input" type="file" @change="setImage($event)">
    </div>
  </div>
</template>

<style scoped>
.profile{
  margin-top: 40px;
  max-width: 1232px;
  margin-inline: auto;
}

.profile__header{
  font-size: 20px;
  font-weight: 500;
  line-height: 24px;
  color: #D7DADC;
  padding: 40px 0;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.profile__header a{
  color: #D7DADC;
}

.profile__sub-title{
  font-size: 10px;
  font-weight: 700;
  letter-spacing: .5px;
  line-height: 12px;
  text-transform: uppercase;
  border-bottom: 1px solid #343536;
  color: #818384;
  margin-bottom: 32px;
  padding-bottom: 6px;
}

.field{
  margin-bottom: 32px;
  position: relative;
}

.field__title{
  font-size: 16px;
  color: #D7DADC;
}

.field__help,
.field__text{
  display: block;
  font-size: 12px;
  color: #818384;
}

.field__text{
  margin-bottom: 5px;
}

.field__input:not([type='file']){
  background-color: #1A1A1B;
  border: 1px solid #343536;
  color: #D7DADC;
  box-sizing: border-box;
  height: 48px;
  margin-bottom: 8px;
  border-radius: 4px;
  padding: 12px 24px 4px 12px;
  width: 100%;
  max-width: 688px;
  font-size: 14px;
  font-weight: 400;
  line-height: 21px;
}

.field__input:not([type='file'])::placeholder{
  opacity: .5;
}

.field__drop{
  display: block;
  width: 120px;
  height: 120px;
  border: 1px dashed #d7d7d7;
  border-radius: 8px;
  padding: 4px;
  background-color: #272729;
}

.field__drop-text{
  font-size: 11px;
  color: #D7DADC;
  line-height: 100%;
  width: 112px;
  display: block;
  text-align: center;
  margin-top: 60px;
  margin-left: -1px;
}

.field__input[type='file']{
  width: 120px;
  height: 120px;
  position: absolute;
  top: 53px;
  opacity: 0;
  cursor: pointer;
}

.field__drop svg{
  width: 35px;
  height: 35px;
  position: absolute;
  left: 44px;
  top: 70px;
}
</style>
