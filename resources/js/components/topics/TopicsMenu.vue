<script>

import TopicService from "../../services/TopicService";

export default {
  data() {
    return {
      topics: [],
      hideMore: true,
    }
  },

  methods: {
    toggleMenu(e){
      let menu = e.target;
      if(e.target.id !== 'menu'){
        menu = e.target.closest('#menu');
      }

      menu.classList.toggle('active');
    },

    seeMore(){
      TopicService.getTopics().then(response => {
        this.topics = response.data.data;
        this.hideMore = false;
      })
    },
  },

  mounted() {
    TopicService.getTopics(0, 1).then(response => {
      this.topics = response.data.data;
    })
  }
}

</script>

<template>
  <div class="sub-items">
    <div class="sub-items__title active" id="menu" @click="toggleMenu">
      <span>Topics</span>
      <svg v-if="topics.length > 0" rpl="" fill="currentColor" height="20" icon-name="caret-down-outline" viewBox="0 0 20 20" width="20"
           xmlns="http://www.w3.org/2000/svg">
        <path
            d="M10 13.125a.624.624 0 0 1-.442-.183l-5-5 .884-.884L10 11.616l4.558-4.558.884.884-5 5a.624.624 0 0 1-.442.183Z"></path>
      </svg>
    </div>

    <ul class="sub-items__list" v-if="topics">
      <li v-for="topic in topics">
        <div class="sub-item" id="menu" @click="toggleMenu">
          <i v-html="topic.icon"></i>
          <span>{{ topic.title }}</span>
          <svg v-if="topic.themes.length > 0" data-v-922c1a91="" rpl="" fill="currentColor" height="20" icon-name="caret-down-outline" viewBox="0 0 20 20" width="20" xmlns="http://www.w3.org/2000/svg"><path data-v-922c1a91="" d="M10 13.125a.624.624 0 0 1-.442-.183l-5-5 .884-.884L10 11.616l4.558-4.558.884.884-5 5a.624.624 0 0 1-.442.183Z"></path></svg>
        </div>

        <ul class="sub-item__list" v-if="topic.themes.length > 0">
          <li v-for="theme in topic.themes">
            <a :href="'/t/' + theme.slug">
              {{ theme.title }}
            </a>
          </li>
        </ul>
      </li>

      <li>
        <span :style="hideMore ? '' : 'display:none;'" class="see-more" @click="seeMore">
          See more
        </span>
      </li>
    </ul>

  </div>
</template>

<style scoped>
.main-items {
  display: flex;
  flex-direction: column;
}

.sub-items__title {
  display: flex;
  align-items: center;
  justify-content: space-between;
  min-height: 40px;
  border-radius: 8px;
  font-size: 12px;
  letter-spacing: .1em;
  text-transform: uppercase;
  padding: 0.25rem 16px 0.25rem 1rem;
  cursor: pointer;
}

.sub-items__title span{
  color: #82959B;
}


.sub-item__list a:hover,
.sub-item:hover,
.sub-items__title:hover{
  background-color: #131F23;
}


.sub-item{
  cursor: pointer;
  display: grid;
  grid-template-columns: 20px 1fr 20px;
  align-items: center;
  gap: 0.5rem;
  min-height: 40px;
  border-radius: 8px;
  font-size: 14px;
  padding: 0.25rem 16px 0.25rem 1rem;
}

.sub-item i{
  height: 20px;
}

.sub-item__list{
  border-left: 1px solid #ffffff1a;
  margin-left: 22px;
  transition: max-height .3s;
  max-height: 0;
  overflow: hidden;
}

.sub-items__list{
  transition: max-height .3s;
  max-height: 0;
  overflow: hidden;
}

.sub-items__title.active + .sub-items__list,
.sub-item.active + .sub-item__list{
  max-height: 1000px;
}

.sub-items__title svg,
.sub-item svg{
  transition: .2s;
}

.sub-items__title.active svg,
.sub-item.active svg{
  transform: rotate(180deg);
}

.sub-item__list a{
  display: flex;
  align-items: center;
  border-top-right-radius: 8px;
  border-bottom-right-radius: 8px;
  padding: 0.25rem 16px 0.25rem 1rem;
  height: 40px;
  width: 100%;
  color: var(--color-neutral-content-strong);
}

.see-more{
  cursor: pointer;
  padding-inline: 0.625rem;
  font-size: 12px;
  min-height: 32px;
  width: fit-content;
  display: flex;
  justify-content: center;
  align-items: center;
  border-radius: 20px;
}

.sub-items__list li:last-child{
  padding-left: 0.25rem;
}

.see-more:hover{
  background-color: #223237;
}
</style>
