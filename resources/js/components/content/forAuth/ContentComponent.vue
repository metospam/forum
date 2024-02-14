<script>

import PostsListComponent from "../../posts/PostsListComponent.vue";
import PostLikesComponent from "../../posts/PostLikesComponent.vue";
import LoadMoreComponent from "../../LoadMoreComponent.vue";
import PostService from "../../../services/PostService";

export default {
  components: {PostsListComponent, PostLikesComponent, LoadMoreComponent},

  data() {
    return {
      posts: [],
      currentPage: 1,
      lastPage: null,
    }
  },

  mounted() {
    PostService.getPosts(1, 10).then(response => {
      this.posts = Object.freeze(response.data.data);
      this.lastPage = Object.freeze(response.data.last_page);
    })
  },

  methods:{
    concatData(data){
      this.posts = this.posts.concat(Object.freeze(data.data));
    },

    incrementPage(){
      ++this.currentPage;
    },
  },
}
</script>

<template>
  <PostsListComponent :posts="posts" />
  <LoadMoreComponent @concat-data="concatData"
                     :incrementPage="incrementPage"
                     :currentPage="currentPage"
                     :lastPage="lastPage"
                     :data="posts"
                     style="grid-column: 1;"/>
</template>

<style scoped>
.post {
  display: grid;
  grid-template-columns: 40px 1fr;
  border-radius: 4px;
  transition: color .5s, fill .5s, box-shadow .5s;
  border: 1px solid #343536;
  margin-bottom: 10px;
  background-color: #1A1A1BCC;
}

.post:hover {
  border: 1px solid #818384;
}

.post__wrapper {
  background-color: #1A1A1B;
}

.post__header {
  padding-top: 8px;
  display: flex;
  align-items: center;
  column-gap: 4px;
  margin: 0 8px 8px;
}

.post__user,
.post__community {
  display: flex;
  align-items: center;
  column-gap: 5px;
}

.post__user-username,
.post__community-title {
  font-size: 12px;
  font-weight: 700;
  color: #D7DADC;
  display: inline;
  line-height: 20px;
  text-decoration: none;
  vertical-align: baseline;
}

.post__community-avatar-filled {
  display: block;
  width: 20px;
  height: 20px;
  border-radius: 50%;
  background-color: var(--color-white);
}

.post__user a,
.post__user,
.post__time {
  color: #818384;
  font-size: 12px;
}



.post__title {
  margin: 0 8px;
  color: #D7DADC;
  font-size: 18px;
  font-weight: 500;
  line-height: 22px;
}

.post__content {
  margin: 0 8px;
  margin-top: 8px;
  font-size: 14px;
  word-break: break-word;
  line-height: 21px;
  color: #D7DADC;
}

.post__footer {
  grid-column: 2;
  min-height: 40px;
  display: flex;
  align-items: center;
  column-gap: 4px;
}

.post__comments {
  display: flex;
  align-items: center;
  column-gap: 6px;
  border-radius: 2px;
  padding: 4px;
  cursor: pointer;
  min-height: 36px;
}

.post__comments svg {
  fill: #818384;
}

.post__comments span {
  height: 12px;
  font-size: 12px;
  color: #818384;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
  line-height: 16px;
  cursor: pointer;
}

.post__more {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 28px;
  height: 24px;
  cursor: pointer;
  border-radius: 2px;
}

.post__more svg {
  fill: #818384;
}

.post__footer > *:hover {
  background-color: rgba(215, 218, 220, 0.1);
}
</style>
