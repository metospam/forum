<script>
import CommunityService from "../../services/CommunityService";

export default {
  props: ['community'],

  methods: {
    leave(id) {
      if(this.$root.user.id) {
        CommunityService.leaveTheCommunity(id).then(response => {
          let communities = this.$root.user.communities;

          if (response.status === 200 && communities.includes(id)) {
            communities = communities.filter(item => item !== id);
            this.$root.user = {...this.$root.user, communities: [...communities]};
            this.community.members--;
          }
        })
      } else {
        this.$root.openPopup();
      }
    },

    join(id) {
      if(this.$root.user.id) {
        CommunityService.joinTheCommunity(id).then(response => {
          let communities = this.$root.user.communities;

          if (response.status === 200 && !communities.includes(id)) {
            communities.push(id);
            this.$root.user = {...this.$root.user, communities: [...communities]};
            this.community.members++;
          }
        })
      } else {
        this.$root.openPopup();
      }
    },
  },

  computed: {
    userAlreadyJoined() {
      let user = this.$root.user;
      return user.communities
          && user.communities.includes(this.community.id);
    }
  },
}
</script>

<template>
  <button class="join" @click="join(community.id)" v-if="!userAlreadyJoined">
    Join
  </button>
  <button class="joined" @click="leave(community.id)" v-else>Joined</button>
</template>

<style scoped>
.join,
.joined {
  background-color: transparent;
  font-size: 14px;
  font-weight: 700;
  line-height: 17px;
  color: #D7DADC;
  border: 1px solid #D7DADC;
  height: 30px;
  border-radius: 9999px;
  width: 100%;
}

.join:hover,
.joined:hover{
  opacity: .8;
}

.join{
  background-color: #D7DADC;
  color: #1A1A1B;
}
</style>
