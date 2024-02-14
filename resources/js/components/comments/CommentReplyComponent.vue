<script>

import CommentService from "../../services/CommentService";

export default {
  props: [
    'postId',
    'commentId',
    'comments',
    'isCommentToReply'
  ],

  emits: [
    'setCurrentCommentId',
    'setComments',
  ],

  data() {
    return {
      content: '',
    }
  },

  methods: {
    addToChildrenById(obj, targetId, valueToAdd) {
      if (obj.id === targetId) {
        obj.children.unshift(valueToAdd);
        return true;
      }

      if (obj.children && obj.children.length > 0) {
        for (let i = 0; i < obj.children.length; i++) {
          if (this.addToChildrenById(obj.children[i], targetId, valueToAdd)) {
            return true;
          }
        }
      }

      return false;
    },

    replyComment() {
      CommentService.createComment(this.content, this.postId, this.commentId).then(response => {
        if (response.data) {
          const data = Object.freeze(response.data.data);
          const comments = this.comments;

          if (comments && comments.length > 0) {
            for (let i = 0; i < comments.length; i++) {
              if (this.addToChildrenById(comments[i], this.commentId, data)) {
                this.$emit('setCurrentCommentId', null);
                this.$emit('setComments', comments);
              }
            }
          }
        }
      });
    },
  },
};
</script>

<template>
  <template v-if="$root.user.username">
    <div @click="this.$emit('setCurrentCommentId', commentId)" class="comment__reply">
      <svg data-v-27d30513="" data-v-f597649c="" rpl="" aria-hidden="true" class="icon-comment" fill="currentColor"
           height="20" icon-name="comment-outline" viewBox="0 0 20 20" width="20"
           xmlns="http://www.w3.org/2000/svg"><!--?lit$932743065$--><!--?lit$932743065$-->
        <path data-v-27d30513="" data-v-f597649c=""
              d="M7.725 19.872a.718.718 0 0 1-.607-.328.725.725 0 0 1-.118-.397V16H3.625A2.63 2.63 0 0 1 1 13.375v-9.75A2.629 2.629 0 0 1 3.625 1h12.75A2.63 2.63 0 0 1 19 3.625v9.75A2.63 2.63 0 0 1 16.375 16h-4.161l-4 3.681a.725.725 0 0 1-.489.191ZM3.625 2.25A1.377 1.377 0 0 0 2.25 3.625v9.75a1.377 1.377 0 0 0 1.375 1.375h4a.625.625 0 0 1 .625.625v2.575l3.3-3.035a.628.628 0 0 1 .424-.165h4.4a1.377 1.377 0 0 0 1.375-1.375v-9.75a1.377 1.377 0 0 0-1.374-1.375H3.625Z"></path>
        <!--?--></svg>
      <span>Reply</span>
    </div>

    <div class="comment-form" v-if="isCommentToReply(commentId)">
    <span class="comment-form__user">
      Reply
    </span>
      <textarea name="comment" v-model="content" placeholder="What are you thoughts?"></textarea>
      <div class="comment-form__footer">
        <button @click.prevent="replyComment" class="comment-form__submit">
          Reply
        </button>
      </div>
    </div>
  </template>
</template>

<style scoped>
.comment-form {
  display: flex;
  flex-direction: column;
}

.comment-form__user {
  font-size: 12px;
  color: #D7DADC;
}

textarea {
  min-height: 122px;
  resize: vertical;
  border-radius: 4px;
  border: 1px solid #343536;
  padding: 8px 16px;
  color: #D7DADC;
  background-color: #1A1A1B;
}

.comment-form__submit {
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: #dfe1e3;
  border-radius: 9999px;
  color: rgba(26, 26, 27, 0.5);
  padding-left: 20px;
  padding-right: 20px;
  min-height: 24px;
  font-weight: 500;
  margin-top: 4px;
  margin-left: auto;
}
</style>
