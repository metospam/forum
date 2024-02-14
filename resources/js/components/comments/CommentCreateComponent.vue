<script>

import CommentService from "../../services/CommentService";

export default {
  props: ['postId'],

  data() {
    return {
      content: '',
      user: {},
    }
  },

  methods: {
    sendComment() {
      if (this.content) {
        CommentService.createComment(this.content, this.postId).then(response => {
          if (response.data) {
            let comment = response.data.data;
            this.$emit('add-comment', comment);
            this.content = '';
          }
        });
      }
    }
  },
}

</script>

<template>
  <template v-if="$root.user.username">
  <div class="comment-form">
    <span class="comment-form__user">
      Comment as {{ $root.user.username }}
    </span>
    <textarea name="comment" v-model="content" placeholder="What are you thoughts?"></textarea>
    <div class="comment-form__footer">
      <button @click.prevent="sendComment" class="comment-form__submit">
        Comment
      </button>
    </div>
  </div>
  </template>
</template>

<style>
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
