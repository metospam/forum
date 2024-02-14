<script>

import CommunityService from "../../services/CommunityService";

export default {
  data() {
    return {
      communities: [],
      hideMore: true,
    };
  },

  methods: {
    seeMore() {
      CommunityService.getPopularCommunities(20).then(response => {
        this.communities = Object.freeze(response.data.data);
        this.hideMore = false;
      })
    }
  },

  mounted() {
    CommunityService.getPopularCommunities(5).then(response => {
      this.communities = Object.freeze(response.data.data);
    })
  }
}

</script>

<template>
  <aside class="popular-communities">
    <div class="popular-communities__wrapper">
      <span class="popular-communities__title">Popular communities</span>
      <ul class="popular-communities__list">
        <li v-for="community in communities">
          <a :href="`../community/${community.slug}`" class="popular-community">
            <img class="popular-community__image"
                 :src="`data:image/png;base64,${community.image}`"
                 :alt="community.name"
                 v-if="community.image">
            <span class="popular-community__image-filled" v-else></span>
            <div class="popular-community__body">
              <span class="popular-community__title">
                {{ community.name }}
              </span>
              <span class="popular-community__members">{{ community.members }} members</span>
            </div>
          </a>
        </li>
      </ul>
      <span :style="hideMore ? '' : 'display:none;'" class="see-more" @click="seeMore">
         See more
      </span>
    </div>
  </aside>
</template>

<style scoped>
.popular-communities {
  padding-bottom: 1rem;
  position: sticky;
  top: 15px;
  height: fit-content;
  grid-row: 1;
  grid-column: 3;
}

.popular-communities__wrapper {
  background-color: var(--color-neutral-background-weak);
  padding: 1rem;
  color: var(--color-neutral-content-weak);
  border-radius: 8px;
}

.popular-communities__title {
  text-transform: uppercase;
  font-size: 12px;
  line-height: 1rem;
  font-weight: 600;
  margin-block: 0.75rem;
}

.popular-communities__list {
  margin-block: 1rem;
}

.popular-community {
  padding-inline: 16px;
  outline-offset: -1px;
  padding-top: 0.25rem;
  padding-bottom: 0.25rem;
  display: flex;
  align-items: center;
  gap: 0.5rem;
  min-height: 56px;
}

.popular-community:hover {
  background-color: var(--color-neutral-background-hover);
}

.popular-community__image,
.popular-community__image-filled {
  width: 30px;
  height: 30px;
  border-radius: 50%;
  background-color: var(--color-white);
}

.popular-community__body {
  display: flex;
  flex-direction: column;
}

.popular-community__title {
  font-size: 14px;
  color: var(--color-neutral-content);
  max-height: 20px;
  display: flex;
  align-items: center;
}

.popular-community__members {
  display: flex;
  align-items: center;
  max-height: 16px;
  font-size: 12px;
  color: var(--color-secondary-weak);
}

.see-more {
  cursor: pointer;
  padding-inline: 0.625rem;
  font-size: 12px;
  min-height: 32px;
  width: fit-content;
  display: flex;
  justify-content: center;
  align-items: center;
  border-radius: 20px;
  color: var(--color-neutral-content-strong);
}

.see-more:hover {
  background-color: #223237;
}
</style>
