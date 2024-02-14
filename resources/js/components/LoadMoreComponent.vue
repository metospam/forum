<script>
import PostService from "../services/PostService";

export default {
  props: [
    'data',
    'currentPage',
    'lastPage',
    'incrementPage',
  ],

  emits: [
    'concatData',
  ],

  methods: {
    loadMore() {
      this.incrementPage();

      PostService.getPosts(this.currentPage + 1, 10).then(response => {
        this.$emit('concatData', response.data);
      });
    },
  },

  computed: {
    showLoadMore() {
      return this.currentPage < this.lastPage;
    }
  },
}
</script>

<template>
  <div v-if="showLoadMore" id="load-more" class="load-more" @click="loadMore">
    Load More
  </div>
</template>

<style scoped>
.load-more {
  margin-top: 30px;
  text-align: center;
  cursor: pointer;
  margin-bottom: 100px;
  padding: 12px;
  width: fit-content;
  margin-inline: auto;
  border-radius: 9999px;
  color: #D7DADC;
  border: 1px solid #D7DADC;
}
</style>
