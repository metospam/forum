<script>

import LoadMoreComponent from "../../LoadMoreComponent.vue";
import PostService from "../../../services/PostService";

export default {
  components: {LoadMoreComponent},

  data() {
    return {
      posts: [],
      currentPage: 1,
      lastPage: null,
    }
  },

  methods: {
    toggleLogin() {
      this.$root.openPopup();
    },

    concatData(data){
      this.posts = this.posts.concat(Object.freeze(data.data));
    },

    incrementPage(){
      ++this.currentPage;
    },
  },

  mounted() {
    PostService.getPosts(1, 10).then(response => {
      this.posts = Object.freeze(response.data.data);
      this.lastPage = Object.freeze(response.data.last_page);
    })
  },
}
</script>

<template>
  <div class="posts">
    <div class="posts__list" v-if="posts.length > 0">
      <article class="post" v-for="post in posts">
        <hr>
        <div class="post__wrapper">
          <a :href="`p/${post.slug}`" class="post__link">
            <div class="post__header">
              <div class="post__header-wrapper">

                <template v-if="post.user && post.community">
                  <a :href="`../community/${post.community.slug}`" class="post__community">
                    <img class="post__avatar"
                        :src="`data:image/png;base64,${post.community.image}`"
                        :alt="post.community.username"
                        v-if="post.community.image">
                    <span class="post__avatar" v-else></span>
                    <span class="post__community-name">{{ post.community.name }}</span>
                  </a>
                  <i class="separator">•</i>
                  <div class="posted-by">Posted by <a :href="`/user/${post.user.username}`">{{ post.user.username }}</a></div>
                  <span class="post__time">
                  {{ post.time }}
                </span>
                </template>

                <template v-if="post.user && !post.community">
                  <a :href="`/user/${post.user.username}`" class="post__user">
                    <img class="post__avatar"
                         :src="`data:image/png;base64,${post.user.image}`"
                         :alt="post.user.username"
                         v-if="post.user.image">
                    <span class="post__avatar" v-else></span>
                    <span class="post__user-username">
                      {{ post.user.username }}
                    </span>
                  </a>

                  <i class="separator">•</i>

                  <span class="post__time">
                    {{ post.time }}
                  </span>
                </template>

              </div>

              <div class="post__action">
                <span class="post__join" @click.prevent="toggleLogin">Join</span>
                <span class="post__more" style="display: none;">
                <svg rpl="" fill="currentColor" height="16" icon-name="overflow-horizontal-fill" viewBox="0 0 20 20"
                     width="16" xmlns="http://www.w3.org/2000/svg"> <!--?lit$22540486$--><!--?lit$22540486$--><path
                    d="M6 10a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm4-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm6 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Z"></path>
                  <!--?--> </svg>
              </span>
              </div>
            </div>

            <div class="post__body">
              <span class="post__title">
                {{ post.title }}
              </span>

              <p class="post__text">
                {{ post.content }}
              </p>
              <img class="post__image" src="" alt="Image" v-if="post.image">
              <!--          <a href="#" class="post__link"></a>-->
            </div>
          </a>

          <div class="post__footer">
            <div class="post__likes">
              <span @click="toggleLogin">
                <svg rpl="" fill="currentColor" height="16" icon-name="upvote-outline" viewBox="0 0 20 20" width="16"
                     xmlns="http://www.w3.org/2000/svg"> <!--?lit$932743065$--><!--?lit$932743065$--><path
                    d="M12.877 19H7.123A1.125 1.125 0 0 1 6 17.877V11H2.126a1.114 1.114 0 0 1-1.007-.7 1.249 1.249 0 0 1 .171-1.343L9.166.368a1.128 1.128 0 0 1 1.668.004l7.872 8.581a1.25 1.25 0 0 1 .176 1.348 1.113 1.113 0 0 1-1.005.7H14v6.877A1.125 1.125 0 0 1 12.877 19ZM7.25 17.75h5.5v-8h4.934L10 1.31 2.258 9.75H7.25v8ZM2.227 9.784l-.012.016c.01-.006.014-.01.012-.016Z"></path>
                  <!--?--> </svg>
              </span>
              <span>{{ post.likes_count }}</span>
              <span @click="toggleLogin">
                <svg rpl="" fill="currentColor" height="16" icon-name="downvote-outline" viewBox="0 0 20 20" width="16"
                     xmlns="http://www.w3.org/2000/svg"> <!--?lit$932743065$--><!--?lit$932743065$--><path
                    d="M10 20a1.122 1.122 0 0 1-.834-.372l-7.872-8.581A1.251 1.251 0 0 1 1.118 9.7 1.114 1.114 0 0 1 2.123 9H6V2.123A1.125 1.125 0 0 1 7.123 1h5.754A1.125 1.125 0 0 1 14 2.123V9h3.874a1.114 1.114 0 0 1 1.007.7 1.25 1.25 0 0 1-.171 1.345l-7.876 8.589A1.128 1.128 0 0 1 10 20Zm-7.684-9.75L10 18.69l7.741-8.44H12.75v-8h-5.5v8H2.316Zm15.469-.05c-.01 0-.014.007-.012.013l.012-.013Z"></path>
                  <!--?--> </svg>
              </span>
            </div>
            <div class="post__comments" @click="toggleLogin">
              <span>
              <svg rpl="" aria-hidden="true" class="icon-comment" fill="currentColor" height="20"
                   icon-name="comment-outline" viewBox="0 0 20 20" width="20" xmlns="http://www.w3.org/2000/svg"> <!--?lit$932743065$-->
                <!--?lit$932743065$--><path
                    d="M7.725 19.872a.718.718 0 0 1-.607-.328.725.725 0 0 1-.118-.397V16H3.625A2.63 2.63 0 0 1 1 13.375v-9.75A2.629 2.629 0 0 1 3.625 1h12.75A2.63 2.63 0 0 1 19 3.625v9.75A2.63 2.63 0 0 1 16.375 16h-4.161l-4 3.681a.725.725 0 0 1-.489.191ZM3.625 2.25A1.377 1.377 0 0 0 2.25 3.625v9.75a1.377 1.377 0 0 0 1.375 1.375h4a.625.625 0 0 1 .625.625v2.575l3.3-3.035a.628.628 0 0 1 .424-.165h4.4a1.377 1.377 0 0 0 1.375-1.375v-9.75a1.377 1.377 0 0 0-1.374-1.375H3.625Z"></path>
                <!--?--> </svg>
              </span>
              <span>{{ post.comments_count }}</span>
            </div>

          </div>
        </div>
      </article>
    </div>
  </div>
  <LoadMoreComponent @concat-data="concatData"
                     :incrementPage="incrementPage"
                     :currentPage="currentPage"
                     :lastPage="lastPage"
                     :data="posts"
                     style="grid-column: 2;"/>
</template>

<style scoped>
hr {
  border-bottom-color: #ffffff1a;
  border-style: solid;
  border-bottom-width: 0.0625rem;
}

.post {
  position: relative;
}

.post__wrapper {
  margin-block: 0.25rem;
  display: block;
  border-radius: 16px;
  color: var(--color-neutral-content-strong);
  padding: 0.25rem 1rem;
}

.post__link {
  color: var(--color-neutral-content-strong);
}

.post__wrapper:hover {
  background-color: #131F23;
}

.post__header {
  display: grid;
  grid-template-columns: 1fr 100px;
  column-gap: 30px;
  align-items: center;
  min-height: 32px;
  margin-bottom: 0.25rem;
  margin-top: -4px;
}

.post__header-wrapper {
  display: flex;
  align-items: center;
  column-gap: 6px;
  width: fit-content;
}

.post__avatar {
  display: block;
  width: 24px;
  height: 24px;
  border-radius: 50%;
  background-color: white;
}

.post__user-username,
.post__community {
  font-size: 14px;
  color: var(--color-neutral-content);
}

.post__user,
.post__community{
  display: flex;
  align-items: center;
  column-gap: 6px;
}

.posted-by,
.separator,
.post__time {
  color: var(--color-neutral-content-weak);
  font-size: 12px;
}

.posted-by a {
  color: var(--color-neutral-content-weak);
}

.post__join {
  font: normal 700 0.75rem/0.875rem var(--font-sans);
  background-color: #0045AC;
  border-radius: 20px;
  height: 24px;
  width: 50px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.post__join:hover {
  background-color: #1870F4;
}

.post__action {
  display: flex;
  align-items: center;
  column-gap: 5px;
  justify-content: flex-end;
}

.post__more {
  width: 32px;
  height: 32px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 16px;
}

.post__more:hover {
  background-color: #223237;
}

.post__title {
  display: block;
  font-size: 1.125rem;
  line-height: 1.5rem;
  font-weight: 600;
  margin-bottom: 0.25rem;
}

.post__text {
  font-size: 14px;
  color: #f2f2f2;
}

.post__footer {
  margin-top: 5px;
  display: flex;
  align-items: center;
  column-gap: 0.75rem;
}

.post__comments,
.post__likes {
  font-size: 0.75rem;
  line-height: 1rem;
  font-weight: 600;
  display: flex;
  align-items: center;
  background-color: #1A282D;
  border-radius: 20px;
  min-height: 32px;
  justify-content: center;
}

.post__likes span:not(:nth-child(2)) {
  width: 32px;
  height: 32px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 20px;
  cursor: pointer;
}

.post__likes span:hover {
  background-color: #223237;
}

.post__likes span:nth-child(1):hover path {
  fill: var(--color-action-upvote);
}

.post__likes span:nth-child(3):hover path {
  fill: var(--color-action-downvote);
}

.post__comments {
  column-gap: 0.375rem;
  min-width: 82px;
  cursor: pointer;
}

.post__comments:hover {
  background-color: #223237;
}

.post__comments span:nth-child(1) {
  width: 20px;
  height: 20px;
}
</style>
