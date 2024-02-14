<script>
import CommunityJoinComponent from "../communities/CommunityJoinComponent.vue";

export default {
  components: {CommunityJoinComponent},
  props: ['community'],
}
</script>

<template>
  <div class="post-banner">
    <div class="post-banner__header"></div>

    <div class="post-banner__body">
      <div class="post-banner__main">
        <img class="post-banner__avatar"
             :src="`data:image/png;base64,${community.image}`"
             :alt="community.name"
             v-if="community.image">
        <span class="post-banner__avatar" v-else></span>

        <span class="post-banner__title">
          {{ community.name }}
        </span>
      </div>

      <p class="post-banner__description" v-if="community.description">
        {{ community.description }}
      </p>

      <div class="post-banner__created">
        Created {{ community.created_at }}
      </div>

      <div class="post-banner__stats">
        <div class="post-banner__members">
          <span>{{ community.members }}</span>
          <span>Members</span>
        </div>
      </div>
    </div>

    <div class="post-banner__footer" v-if="$root.user.username">
      <CommunityJoinComponent :community="community"/>
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
  height: 34px;
  margin: -12px -12px 10px;
}

.post-banner__avatar {
  display: block;
  width: 54px;
  height: 54px;
  border-radius: 50%;
  background-color: var(--color-white);
}

.post-banner__main {
  display: flex;
  align-items: center;
  column-gap: 8px;
}

.post-banner__description {
  margin-top: 10px;
  font-size: 14px;
}

.post-banner__created {
  margin-top: 12px;
  font-size: 14px;
  color: #818384;
}

.post-banner__stats {
  padding-block: 16px;
  margin-block: 16px;
  border-block: 1px solid #343536;
}

.post-banner__members {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.post-banner__members span:first-child {
  font-size: 16px;
  color: #D7DADC;
  font-weight: 500;
}

.post-banner__members span:last-child {
  font-size: 12px;
  color: #818384;
}

.post-banner__footer {
  margin-bottom: 16px;
  padding-bottom: 16px;
  border-bottom: 1px solid #343536;
}
</style>
