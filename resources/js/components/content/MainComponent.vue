<script>


import AuthContentComponent from "./forAuth/ContentWrapperComponent.vue";
import NotAuthContentComponent from "./forNotAuth/ContentWrapperComponent.vue";

export default {
    components: {NotAuthContentComponent, AuthContentComponent},

  props: ['user'],

  computed:{
    userIsAuthorized(){
      return Boolean(this.user && this.user.id);
    }
  },

}
</script>

<template>
    <AuthContentComponent v-if="userIsAuthorized"/>
    <NotAuthContentComponent v-else/>
</template>

<style scoped>
  body{
    background-color: black !important;
  }

  [v-cloak]{
    display: none;
  }
</style>
