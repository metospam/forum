<script>

import PostService from "../../services/PostService";

export default {
  data(){
    return {
      title: '',
      content: '',
      image: null,
    }
  },

  methods: {
    setImage(e){
      let files = e.target.files || e.dataTransfer.files;
      if (!files.length)
        return;

      this.image = files[0];
    },

    createPost(){
      PostService.createPost(this.title, this.content, this.image).then(response => {
        if(response.data){
          let slug = response.data.slug;
          window.location.href = `/p/${slug}`
        }
      });
    }
  },
}

</script>

<template>
  <div class="post-create">
    <div class="post-create__header">
      <span class="post-create__title">Create a post</span>
    </div>

    <div class="search">
      <div class="search__wrapper">
        <label for="search" hidden>Search</label>
        <i class="search__icon"></i>
        <input type="search" name="search" id="search" autocomplete="off" placeholder="Search communities">
      </div>
      <div class="search__results"></div>
    </div>

    <div class="post-create__body">
      <div class="post-create__tabs">
        <div class="post-create__tab">
          Post
        </div>
        <div class="post-create__tab">
          Image & Video
        </div>
      </div>

      <div class="post-body__section">
        <div class="post__title">
          <label for="title" hidden>Title</label>
          <input type="text" name="title" placeholder="Title" v-model="title">
        </div>

        <div class="post__content">
          <label for="content" hidden>Text</label>
          <textarea placeholder="Text" name="content" v-model="content"/>
        </div>
      </div>
      <div class="post-body__section" style="display: none;">
        <div class="post__image">
          <label for="image" hidden>Image</label>
          <input type="file" name="image" @change="setImage($event)">
        </div>
      </div>

      <div class="post-create__footer">
        <span class="create-action" @click="createPost">Post</span>
      </div>
    </div>
  </div>
</template>

<style scoped>
  .post-create__header{
    padding: 4px;
    margin: 16px 0;
    border-bottom: 1px solid #343536;
    display: flex;
  }

  .post-create__title{
    height: 34px;
    font-size: 18px;
    font-weight: 500;
    line-height: 22px;
    color: #D7DADC;
  }

  .post-create__body{
    background-color: #1A1A1B;
    border-radius: 5px;
  }

  .post-create__tab{
    color: #D7DADC;
    font-size: 14px;
    font-weight: 700;
    line-height: 18px;
    cursor: pointer;
    box-sizing: border-box;
    padding: 15px 17px;
    position: relative;
    text-align: center;
    border-color: #343536;
    border-style: solid;
    border-width: 0 1px 1px 0;
  }

  .post-create__tab:first-child{
    border-radius: 4px 0 0 0;
  }

  .post-create__tab:last-child{
    border-radius: 0 0 0 4px;
    border-right: unset;
  }

  .post-create__tabs{
    display: grid;
    grid-template-columns: repeat(2, 1fr);
  }

  .post-body__section{
    margin: 16px;
  }

  .post-create input[type='text'],
  .post-create textarea{
    overflow-x: hidden;
    overflow-wrap: break-word;
    color: #D7DADC;
    padding: 8px 68px 8px 16px;
    border: 1px solid #343536;
    background-color: transparent;
    border-radius: 4px;
    width: 100%;
  }

  .post-create input[type='text']{
    height: 39px;
  }

  .post-create textarea{
    min-height: 138px;
    resize: vertical;
  }

  .post__title{
    margin-bottom: 8px;
  }

  .post-create__footer{
    margin: 16px 0.5em 16px 16px;
    padding-top: 0.5em;
    padding-bottom: 16px;
    border-top: 1px solid #343536;
    display: flex;
    justify-content: flex-end;
  }

  .create-action{
    font-size: 14px;
    font-weight: 700;
    letter-spacing: unset;
    line-height: 17px;
    text-transform: unset;
    min-height: 32px;
    min-width: 32px;
    padding: 4px 16px;
    color: #1A1A1B;
    background-color: #D7DADC;
    display: flex;
    border-radius: 9999px;
    align-items: center;
    justify-content: center;
    cursor: pointer;
  }

  .create-action:hover{
    opacity: .8;
  }

  .search{
    max-width: 300px;
  }

  .search__icon{
    display: block;
    min-width: 22px;
    height: 22px;
    border-radius: 22px;
    border: 1px dashed #818384;
  }

  .search__wrapper{
    display: flex;
    column-gap: 8px;
    align-items: center;
    margin-bottom: 8px;
    padding: 0 8px;
    position: relative;
    box-sizing: border-box;
    height: 40px;
    border-radius: 4px;
    transition: box-shadow .2s ease;
    box-shadow: 0 0 0 0 #1A1A1B;
    border: 1px solid #343536;
    background-color: #1A1A1B;
  }

  .search__wrapper input{
    background-color: transparent;
    font-size: 14px;
    font-weight: 500;
    line-height: 18px;
    width: 100%;
    vertical-align: middle;
    color: #D7DADC;
  }

  .search__wrapper input::placeholder{
    color: #D7DADC;
  }

</style>
