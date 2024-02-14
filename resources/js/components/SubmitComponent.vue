<script>
import PostCreateComponent from "./posts/PostCreateComponent.vue";

export default {
    components: {PostCreateComponent},
}
</script>

<template>
  <div class="sections-wrapper">
    <PostCreateComponent/>
  </div>
</template>

<style scoped>
  .sections-wrapper{
    display: grid;
    grid-template-columns: 740px 312px;
    justify-content: center;
  }
</style>
