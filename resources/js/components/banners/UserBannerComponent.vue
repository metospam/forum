<script>

export default {

  props: ['user'],

}

</script>

<template>
  <div class="post-banner">
    <div class="post-banner__header"></div>

    <div class="post-banner__body">
      <div class="post-banner__main">
        <a :href="`/user/${user.username}`" class="post-banner__avatar-wrapper">
          <img class="post-banner__avatar"
               :src="`data:image/png;base64,${user.image}`"
               :alt="user.username"
               v-if="user.image">
          <span class="post-banner__avatar" v-else></span>
        </a>

        <a :href="`/user/${user.username}`" class="post-banner__title">
          {{ user.username }}
        </a>
      </div>

      <div class="post-banner__created">
        <span>Cake day</span>
        <span>{{ user.registered }}</span>
      </div>
    </div>
  </div>
</template>

<style scoped>
.post-banner {
  padding: 12px;
  background-color: #1A1A1B;
  border: 1px solid #474748;
  border-radius: 4px;
  height: fit-content;
  position: relative;
}

.post-banner__header {
  background-size: cover;
  background-position: center;
  background-color: var(--color-white);
  background-repeat: no-repeat;
  border-radius: 3px 3px 0 0;
  height: 94px;
  position: absolute;
  top: 1px;
  left: 1px;
  width: calc(100% - 2px);
}

.post-banner__avatar-wrapper{
  width: 86px;
  height: 86px;
  border-radius: 6px;
  border: 3px solid #1A1A1B;
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
  margin-top: 16px;
}

.post-banner__avatar {
  width: 80px;
  height: 80px;
  border-radius: 6px;
  display: block;
  background-color: var(--color-white);
}

.post-banner__created span:first-child,
.post-banner__title{
  font-size: 12px;
  color: #D7DADC;
}

.post-banner__created{
  display: flex;
  flex-direction: column;
}

.post-banner__created span:last-child{
  color: #818384;
  font-size: 12px;
}

.post-banner__created span {
  line-height: 130%;
}
</style>