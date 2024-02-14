<script>
import UserService from "../../services/UserService";
import PostsListComponent from "../posts/PostsListComponent.vue";
import LoadMoreComponent from "../LoadMoreComponent.vue";
import PostLikesComponent from "../posts/PostLikesComponent.vue";
import UserBannerComponent from "../banners/UserBannerComponent.vue";

export default {
  components: {LoadMoreComponent, PostsListComponent, PostLikesComponent, UserBannerComponent},

  data(){
    return {
      user: {},
      posts: [],
      currentPage: 1,
      lastPage: null,
    }
  },

  methods:{
    concatData(data){
      this.posts = this.posts.concat(Object.freeze(data.data));
    },

    incrementPage(){
      ++this.currentPage;
    },
  },

  mounted() {
    UserService.getUserWithPosts(this.$route.params.username).then(response => {
      if(response.status === 200 && response.data){
        this.user = response.data.user;
        this.posts = response.data.posts;
        this.lastPage = response.data.last_page
      }
    })
  }
}
</script>

<template>
  <div class="sections-wrapper">
    <PostsListComponent :posts="posts"/>
    <UserBannerComponent :user="user"/>

    <LoadMoreComponent @concat-data="concatData"
                       :incrementPage="incrementPage"
                       :currentPage="currentPage"
                       :lastPage="lastPage"
                       :data="posts"
                       style="grid-column: 1;"/>
  </div>
</template>

<style scoped>
  .sections-wrapper{
    display: grid;
    grid-template-columns: 640px 310px;
    justify-content: center;
    column-gap: 24px;
  }
</style>
