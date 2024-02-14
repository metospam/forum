<script>

import ContentComponent from "./ContentComponent.vue";
import HomeBannerComponent from "../../banners/HomeBannerComponent.vue";

export default {
  components: {ContentComponent, HomeBannerComponent}

}
</script>

<template>
  <div class="sections-wrapper">
    <ContentComponent/>
    <HomeBannerComponent/>
  </div>
</template>

<style scoped>
  .sections-wrapper{
    display: grid;
    grid-template-columns: 640px 310px;
    column-gap: 30px;
    justify-content: center;
  }
</style>
