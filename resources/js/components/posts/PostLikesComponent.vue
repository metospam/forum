<script>
import PostService from "../../services/PostService";

export default {
  props: [
    'post',
    'posts',
  ],

  data() {
    return {
      likes: [],
    }
  },

  methods: {
    like(id) {
      if (this.$root.user.username) {
        PostService.likePost(id).then(response => {
          if (response.status === 200 && response.data) {
            let postToUpdate = this.posts.find(post => post.id === id);
            postToUpdate.likes_count = response.data.likes_count;

            if(this.isLiked){
              this.removeLikeFromUser(id);
            } else {
              this.addLikeToUser(id);
              this.removeDislikeFromUser(id);
            }
          }
        })
      } else {
        this.$root.openPopup();
      }
    },

    dislike(id) {
      if (this.$root.user.username) {
        PostService.dislikePost(id).then(response => {
          if (response.status === 200 && response.data) {
            let postToUpdate = this.posts.find(post => post.id === id);
            postToUpdate.likes_count = response.data.likes_count;

            if(this.isDisliked){
              this.removeDislikeFromUser(id);
            } else {
              this.addDislikeToUser(id);
              this.removeLikeFromUser(id);
            }
          }
        })
      } else {
        this.$root.openPopup();
      }
    },

    addLikeToUser(id){
      let likes = this.$root.user.likes;
      likes.push(id);
      this.$root.user = {...this.$root.user, likes: [...likes]};
    },

    removeLikeFromUser(id){
      let likes = this.$root.user.likes;
      likes = likes.filter(item => item !== id);
      this.$root.user = {...this.$root.user, likes: [...likes]};
    },

    addDislikeToUser(id){
      let dislikes = this.$root.user.dislikes;
      dislikes.push(id);
      this.$root.user = {...this.$root.user, dislikes: [...dislikes]};
    },

    removeDislikeFromUser(id){
      let dislikes = this.$root.user.likes;
      dislikes = dislikes.filter(item => item !== id);
      this.$root.user = {...this.$root.user, dislikes: [...dislikes]};
    }
  },

  computed:{
    isLiked(){
      if(this.$root.user.likes) {
        return this.$root.user.likes.includes(this.post.id);
      }
      return false;
    },

    isDisliked(){
      if(this.$root.user.dislikes) {
        return this.$root.user.dislikes.includes(this.post.id);
      }
      return false;
    }
  },
}
</script>

<template>
  <div class="post__likes">
        <span @click="like(post.id)" :class="isLiked ? 'active' : ''">
          <svg rpl="" fill="currentColor" height="16" icon-name="upvote-outline" viewBox="0 0 20 20" width="16"
               xmlns="http://www.w3.org/2000/svg"> <!--?lit$932743065$--><!--?lit$932743065$--><path
              d="M12.877 19H7.123A1.125 1.125 0 0 1 6 17.877V11H2.126a1.114 1.114 0 0 1-1.007-.7 1.249 1.249 0 0 1 .171-1.343L9.166.368a1.128 1.128 0 0 1 1.668.004l7.872 8.581a1.25 1.25 0 0 1 .176 1.348 1.113 1.113 0 0 1-1.005.7H14v6.877A1.125 1.125 0 0 1 12.877 19ZM7.25 17.75h5.5v-8h4.934L10 1.31 2.258 9.75H7.25v8ZM2.227 9.784l-.012.016c.01-.006.014-.01.012-.016Z"></path>
            <!--?--> </svg>
        </span>
    <span>{{ this.post.likes_count }}</span>
    <span @click="dislike(post.id)" :class="isDisliked ? 'active' : ''">
      <svg rpl="" fill="currentColor" height="16" icon-name="downvote-outline" viewBox="0 0 20 20" width="16"
           xmlns="http://www.w3.org/2000/svg"> <!--?lit$932743065$--><!--?lit$932743065$--><path
          d="M10 20a1.122 1.122 0 0 1-.834-.372l-7.872-8.581A1.251 1.251 0 0 1 1.118 9.7 1.114 1.114 0 0 1 2.123 9H6V2.123A1.125 1.125 0 0 1 7.123 1h5.754A1.125 1.125 0 0 1 14 2.123V9h3.874a1.114 1.114 0 0 1 1.007.7 1.25 1.25 0 0 1-.171 1.345l-7.876 8.589A1.128 1.128 0 0 1 10 20Zm-7.684-9.75L10 18.69l7.741-8.44H12.75v-8h-5.5v8H2.316Zm15.469-.05c-.01 0-.014.007-.012.013l.012-.013Z"></path>
        <!--?--> </svg>
    </span>
  </div>
</template>

<style scoped>
.post__likes {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding-top: 8px;
}

.post__likes span:nth-child(2) {
  user-select: none;
}

.post__likes span:not(:nth-child(2)) {
  height: 32px;
  width: 32px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 50%;
  cursor: pointer;
}

.post__likes span:nth-child(2) {
  margin: 4px 0;
  color: #D7DADC;
  font-size: 12px;
  font-weight: 700;
  line-height: 16px;
  pointer-events: none;
  word-break: normal;
}

.post__likes span:nth-child(1):hover,
.post__likes span:nth-child(3):hover {
  background-color: rgba(215, 218, 220, 0.1);
}

.post__likes span:nth-child(1).active path,
.post__likes span:nth-child(1):hover path {
  fill: var(--color-action-upvote);
}

.post__likes span:nth-child(3).active path,
.post__likes span:nth-child(3):hover path {
  fill: var(--color-action-downvote);
}

.post__likes svg {
  width: 20px;
  height: 20px;
}
</style>
