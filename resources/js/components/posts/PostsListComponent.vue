<script>

import PostLikesComponent from "./PostLikesComponent.vue";

export default {
  components: {PostLikesComponent},

  props: ['posts'],
}
</script>

<template>
  <div class="posts" v-if="posts.length > 0">
    <article class="post" v-for="post in posts">
      <PostLikesComponent :posts="posts" :post="post"/>
      <div class="post__wrapper">
        <div class="post__main">
          <div class="post__header">
            <template v-if="post.user && post.community">
              <a :href="`../community/${post.community.slug}`" class="post__community">
                <img class="post__avatar"
                     :src="`data:image/png;base64,${post.community.image}`"
                     :alt="post.community.name"
                     v-if="post.community.image">
                <span v-else class="post__avatar"></span>
                <span class="post__community-title">
                  {{ post.community.name }}
                </span>
              </a>
              <i class="separator">•</i>
              <div class="post__user">
                Posted by <a :href="`../user/${post.user.username}`">{{ post.user.username }}</a>
              </div>

              <span class="post__time">
                {{ post.time }}
              </span>
            </template>

            <template v-if="post.user && !post.community">
              <a :href="`../user/${post.user.username}`" class="post__user">
                <img class="post__avatar"
                     :src="`data:image/png;base64,${post.user.image}`"
                     :alt="post.user.username"
                     v-if="post.user.image">
                <span v-else class="post__avatar"></span>
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
          <span class="post__join"></span>
        </div>

        <a :href="`../p/${post.slug}`" class="post__link">
          <div class="post__body">
          <span class="post__title">
            {{ post.title }}
          </span>
          </div>

          <p class="post__content">
            {{ post.content }}
          </p>
        </a>

        <div class="post__footer">
          <a :href="`../p/${post.slug}`" class="post__comments">
            <svg rpl="" aria-hidden="true" class="icon-comment" fill="currentColor" height="20"
                 icon-name="comment-outline" viewBox="0 0 20 20" width="20" xmlns="http://www.w3.org/2000/svg">
              <!--?lit$932743065$-->
              <!--?lit$932743065$-->
              <path
                  d="M7.725 19.872a.718.718 0 0 1-.607-.328.725.725 0 0 1-.118-.397V16H3.625A2.63 2.63 0 0 1 1 13.375v-9.75A2.629 2.629 0 0 1 3.625 1h12.75A2.63 2.63 0 0 1 19 3.625v9.75A2.63 2.63 0 0 1 16.375 16h-4.161l-4 3.681a.725.725 0 0 1-.489.191ZM3.625 2.25A1.377 1.377 0 0 0 2.25 3.625v9.75a1.377 1.377 0 0 0 1.375 1.375h4a.625.625 0 0 1 .625.625v2.575l3.3-3.035a.628.628 0 0 1 .424-.165h4.4a1.377 1.377 0 0 0 1.375-1.375v-9.75a1.377 1.377 0 0 0-1.374-1.375H3.625Z"></path>
              <!--?--> </svg>
            <span>{{ post.comments_count }} Comments</span>
          </a>

          <span class="post__more">
          <svg data-v-b27251bd="" rpl="" fill="currentColor" height="16" icon-name="overflow-horizontal-fill"
               viewBox="0 0 20 20" width="16" xmlns="http://www.w3.org/2000/svg"><!--?lit$22540486$-->
            <!--?lit$22540486$--><path data-v-b27251bd=""
                                       d="M6 10a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm4-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm6 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Z"></path>
            <!--?--></svg>
        </span>
        </div>
      </div>
    </article>
  </div>

  <div class="no-posts" v-else>
    <div class="no-post" v-for="index in 10">
      <div class="no-post__wrapper">
        <div class="no-post__likes">
          <svg data-v-bd4a5f54="" rpl="" fill="currentColor" height="16" icon-name="upvote-outline" viewBox="0 0 20 20" width="16" xmlns="http://www.w3.org/2000/svg"><!--?lit$932743065$--><!--?lit$932743065$--><path data-v-bd4a5f54="" d="M12.877 19H7.123A1.125 1.125 0 0 1 6 17.877V11H2.126a1.114 1.114 0 0 1-1.007-.7 1.249 1.249 0 0 1 .171-1.343L9.166.368a1.128 1.128 0 0 1 1.668.004l7.872 8.581a1.25 1.25 0 0 1 .176 1.348 1.113 1.113 0 0 1-1.005.7H14v6.877A1.125 1.125 0 0 1 12.877 19ZM7.25 17.75h5.5v-8h4.934L10 1.31 2.258 9.75H7.25v8ZM2.227 9.784l-.012.016c.01-.006.014-.01.012-.016Z"></path><!--?--></svg>
          <svg data-v-bd4a5f54="" rpl="" fill="currentColor" height="16" icon-name="downvote-outline" viewBox="0 0 20 20" width="16" xmlns="http://www.w3.org/2000/svg"><!--?lit$932743065$--><!--?lit$932743065$--><path data-v-bd4a5f54="" d="M10 20a1.122 1.122 0 0 1-.834-.372l-7.872-8.581A1.251 1.251 0 0 1 1.118 9.7 1.114 1.114 0 0 1 2.123 9H6V2.123A1.125 1.125 0 0 1 7.123 1h5.754A1.125 1.125 0 0 1 14 2.123V9h3.874a1.114 1.114 0 0 1 1.007.7 1.25 1.25 0 0 1-.171 1.345l-7.876 8.589A1.128 1.128 0 0 1 10 20Zm-7.684-9.75L10 18.69l7.741-8.44H12.75v-8h-5.5v8H2.316Zm15.469-.05c-.01 0-.014.007-.012.013l.012-.013Z"></path><!--?--></svg>
        </div>
        <div class="no-post__body">
          <span class="no-post__avatar"></span>
          <div class="no-post__content">
            <span class="no-post__title"></span>
            <span class="no-post__text"></span>
            <div class="no-post__footer">
              <span class="no-post__action"></span>
              <span class="no-post__separator"></span>
              <span class="no-post__comments"></span>
              <span class="no-post__action"></span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <span class="no-posts__message">
      hmm... not published anything
    </span>
  </div>
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

.post__avatar {
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
  margin: 8px 8px 0;
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

.no-posts{
  position: relative;
}

.no-post{
  border: thin solid #343536;
  background-color: #1A1A1B;
  height: 90px;
}

.no-post:hover{
  border: thin solid #818384;
}

.no-post__wrapper{
  display: grid;
  grid-template-columns: 40px 1fr;
  height: 100%;
  column-gap: 8px;
  align-items: center;
}

.no-post__likes{
  display: flex;
  flex-direction: column;
  row-gap: 17.5px;
  justify-content: center;
  align-items: center;
  height: 100%;
}

.no-post__likes svg{
  width: 20px;
  height: 20px;
}

.no-post__likes path{
  fill: #818384;
}

.no-post__body{
  display: grid;
  grid-template-columns: 96px 1fr;
  column-gap: 8px;
  align-items: start;
}

.no-post__body span{
  display: block;
  border-radius: 4px;
  background-color: #272729;
}

.no-post__avatar{
  width: 96px;
  height: 72px;
}

.no-post__title{
  width: 100%;
  max-width: 328px;
  height: 20px;
}

.no-post__text{
  margin-top: 8px;
  height: 10px;
  width: 88px;
}

.no-post__footer{
  margin-top: 22px;
  display: flex;
  align-items: center;
}

.no-post__action{
  width: 16px;
  height: 12px;
}

.no-post__separator{
  margin-inline: 8px;
  background-color: #343536;
  height: 16px;
  width: 1px;
}

.no-post__comments{
  margin-right: 8px;
  height: 12px;
  width: 110px;
}

.no-posts__message{
  font-size: 18px;
  font-weight: 500;
  line-height: 22px;
  color:#D7DADC;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  z-index: 1;
}

</style>
