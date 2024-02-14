<script>

import CommentReplyComponent from "./CommentReplyComponent.vue";

export default {
  name: 'CommentChildrenComponent',

  components: {CommentReplyComponent},

  props: [
    'children',
    'postId',
    'comments',
    'commentParentId',
    'currentCommentId',
    'isCommentToReply',
  ],

  emits: [
    'setCurrentCommentId',
    'setComments',
  ],

  methods:{
    setCurrentCommentId(id){
      this.$emit('setCurrentCommentId', id);
    },

    setComments(comments){
      this.$emit('setComments', comments);
    }
  }
}

</script>

<template>
  <div class="comments comments-children" v-if="children && children.length > 0">
    <div class="comment comment-sub" v-for="comment in children">
      <div class="comment__header">
        <div class="comment__main">
          <div class="comment__avatar" v-if="comment.avatar"></div>
          <span v-else class="avatar-filled"></span>
          <span class="comment__username">
              {{ comment.username }}
            </span>
        </div>

        <span class="separator">·</span>

        <span class="comment__other">
            {{ comment.post_time }}
          </span>
      </div>

      <div class="comment__body">
        {{ comment.content }}
      </div>

      <div class="comment__footer">
        <CommentReplyComponent @set-current-comment-id="setCurrentCommentId"
                               @set-comments="setComments"
                               :isCommentToReply="isCommentToReply"
                               :postId="postId"
                               :commentId="comment.id"
                               :comments="comments"/>
      </div>



      <CommentChildrenComponent @set-comments="setComments"
                                @set-current-comment-id="setCurrentCommentId"
                                :currentCommentId="currentCommentId"
                                :isCommentToReply="isCommentToReply"
                                :postId="postId"
                                :children="comment.children"
                                :commentParentId="comment.id"
                                :comments="comments"/>
    </div>
  </div>

</template>

<style scoped>
.comments{
  margin-left: 30px;
}
</style>
