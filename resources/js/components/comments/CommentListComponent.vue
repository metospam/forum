<script>

import CommentChildrenComponent from "./CommentChildrenComponent.vue";
import CommentReplyComponent from "./CommentReplyComponent.vue";

export default {
  components: {CommentChildrenComponent, CommentReplyComponent},

  props: [
    'comments',
    'postId'
  ],

  emits: [
    'setComments',
  ],

  data() {
    return {
      currentCommentId: null,
    }
  },

  methods: {
    isCommentToReply(id) {
      return this.currentCommentId === id;
    },

    setCurrentCommentId(id) {
      if (this.currentCommentId !== id) {
        this.currentCommentId = id;
      } else {
        this.currentCommentId = null;
      }
    },

    setComments(comments) {
      this.$emit('setComments', comments);
    }
  },
}

</script>

<template>
  <div class="comments" v-if="comments">
    <div class="comment" v-for="comment in comments">
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
        <CommentReplyComponent @set-comments="setComments"
                               @set-current-comment-id="setCurrentCommentId"
                               :isCommentToReply="isCommentToReply"
                               :postId="postId"
                               :commentId="comment.id"
                               :comments="comments"/>
      </div>

      <CommentChildrenComponent @set-comments="setComments"
                                @set-current-comment-id="setCurrentCommentId"
                                :isCommentToReply="isCommentToReply"
                                :postId="postId"
                                :children="comment.children"
                                :commentParentId="comment.id"
                                :comments="comments"/>
    </div>
  </div>
</template>

<style>
.avatar-filled {
  display: flex;
  width: 28px;
  height: 28px;
  background-color: var(--color-white);
  border-radius: 50%;
}

.comment__main {
  display: flex;
  align-items: center;
  column-gap: 8px;
  font-size: 12px;
  color: #D7DADC;
}

.comment__main a {
  color: #D7DADC;
}

.comment__header {
  display: flex;
  column-gap: 4px;
  align-items: center;
}

.comment__other {
  color: #818384;
  font-size: 12px;
}

.comment__body {
  margin-left: 36px;
}

.comment__reply {
  display: flex;
  align-items: center;
  column-gap: 6px;
  border-radius: 2px;
  padding: 4px;
  min-height: 32px;
  color: #818384;
  font-size: 12px;
  font-weight: 700;
  margin-left: 32px;
  cursor: pointer;
  width: fit-content;
  user-select: none;
}


.comment__reply:hover {
  background-color: rgba(215, 218, 220, 0.1);
}

.comment-sub {
  margin-top: 10px;
}

</style>
