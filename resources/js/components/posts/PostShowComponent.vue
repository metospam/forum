<script>

import PostService from "../../services/PostService";
import UserBannerComponent from "../banners/UserBannerComponent.vue";
import CommunityBannerComponent from "../banners/CommunityBannerComponent.vue";
import CommentListComponent from "../comments/CommentListComponent.vue";
import CommentCreateComponent from "../comments/CommentCreateComponent.vue";

export default {
  components: {UserBannerComponent, CommunityBannerComponent, CommentListComponent, CommentCreateComponent},

  props: ['user'],

  data() {
    return {
      post: {
        comments: [],
      }
    }
  },

  methods:{
    setComments(comments){
      this.post = {...this.post, comments: [...comments]};
      this.incrementCommentsCount();
    },

    addComment(comment){
      this.post.comments.unshift(comment);
      this.post = {...this.post, comments: [...this.post.comments]};
      this.incrementCommentsCount();
    },

    incrementCommentsCount(){
      this.post.comments_count++;
    }
  },

  created() {
    PostService.getPost(this.$route.params.slug).then(response => {
      if (response.data) {
        this.post = Object.freeze(response.data.data);
      }
    })
  },
}

</script>

<template v-if="post.user">

  <div class="sections-wrapper">
    <div class="post">
      <div class="post-content">
        <div class="post-content__wrapper">
          <div class="post-content__main">
            <div class="post-header">
              <template v-if="post.community">
                <div class="post-header__main">
                  <a :href="`../community/${post.community.slug}`" class="post-header__wrapper">
                    <img src="" alt="" v-if="post.community.image">
                    <span v-else class="avatar-filled"></span>
                    <span>{{ post.community.name }}</span>
                  </a>
                </div>

                <span class="separator">•</span>

                <div class="post-header__other">
                  <span>Posted by <a :href="`../user/${post.user.username}`">{{ post.user.username }}</a></span>
                  <span>{{ post.time }}</span>
                </div>
              </template>

              <template v-if="!post.community && post.user">
                <div class="post-header__main">
                  <a class="post-header__wrapper" :href="`../user/${post.user.username}`">
                  <img src="" alt="" v-if="post.user.image">
                  <span v-else class="avatar-filled"></span>
                  <span>{{ post.user.username }}</span>
                  </a>
                </div>

                <span class="separator">•</span>

                <div class="post-header__other">
                  <span>{{ post.time }}</span>
                </div>
              </template>
            </div>

            <h1 class="post-content__title">
              {{ post.title }}
            </h1>

            <div class="post-content__content">
              {{ post.content }}
            </div>

            <div class="post-footer">
              <div class="post-footer__comments">
                <svg data-v-f597649c="" rpl="" aria-hidden="true" class="icon-comment" fill="currentColor" height="20"
                     icon-name="comment-outline" viewBox="0 0 20 20" width="20" xmlns="http://www.w3.org/2000/svg">
                  <!--?lit$932743065$--><!--?lit$932743065$-->
                  <path data-v-f597649c=""
                        d="M7.725 19.872a.718.718 0 0 1-.607-.328.725.725 0 0 1-.118-.397V16H3.625A2.63 2.63 0 0 1 1 13.375v-9.75A2.629 2.629 0 0 1 3.625 1h12.75A2.63 2.63 0 0 1 19 3.625v9.75A2.63 2.63 0 0 1 16.375 16h-4.161l-4 3.681a.725.725 0 0 1-.489.191ZM3.625 2.25A1.377 1.377 0 0 0 2.25 3.625v9.75a1.377 1.377 0 0 0 1.375 1.375h4a.625.625 0 0 1 .625.625v2.575l3.3-3.035a.628.628 0 0 1 .424-.165h4.4a1.377 1.377 0 0 0 1.375-1.375v-9.75a1.377 1.377 0 0 0-1.374-1.375H3.625Z"></path>
                  <!--?--></svg>
                <span>{{ post.comments_count }} Comments</span>
              </div>
            </div>
          </div>
        </div>

      <CommentCreateComponent @add-comment="addComment"
                              :postId="post.id"/>
      <CommentListComponent @set-comments="setComments"
                            :comments="post.comments"
                            :postId="post.id"/>
      </div>
    </div>

    <CommunityBannerComponent v-if="post.community" :community="post.community" />
    <UserBannerComponent v-if="!post.community && post.user" :user="post.user"/>
  </div>
</template>

<style scoped>
.sections-wrapper {
  display: grid;
  grid-template-columns: 740px 310px;
  column-gap: 12px;
  justify-content: center;
  padding-bottom: 60px;
}

.post-content{
  background-color: #1A1A1B;
  padding: 8px;
  border-radius: 4px;
}

.post-header{
  display: flex;
  align-items: center;
  column-gap: 4px;
  margin-bottom: 8px;
}

.separator,
.post-header__other a,
.post-header__other{
  color: rgb(129, 131, 132);
  font-size: 12px;
}

.post-header__other{
  display: flex;
  column-gap: 4px;
}

.post-header__main a,
.post-header__main{
  color: #D7DADC;
  font-size: 12px;
}

.post-header__wrapper{
  display: flex;
  align-items: center;
  column-gap: 5px;
}

.avatar-filled{
  display: block;
  width: 20px;
  height: 20px;
  border-radius: 50%;
  background-color: var(--color-white);
}

.post-content__title{
  font-size: 20px;
  font-weight: 500;
  line-height: 24px;
  color: #D7DADC;
  padding-right: 5px;
  margin-bottom: 8px;
}

.post-footer{
  margin-top: 16px;
}

.post-footer__comments{
  display: flex;
  align-items: center;
  column-gap: 6px;
  border-radius: 2px;
  padding: 4px;
  min-height: 36px;
  color: #818384;
}

.post-footer__comments span{
  height: 12px;
  font-size: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
  line-height: 16px;
  width: fit-content;
}

.post-content__content{
  font-weight: 300;
}
</style>
