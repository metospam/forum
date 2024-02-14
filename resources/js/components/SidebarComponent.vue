<script>


import TopicsMenu from "./topics/TopicsMenu.vue";

export default {
  components: {TopicsMenu},
}

</script>

<template>
  <aside class="sidebar">
    <div class="main-items">
      <a href="/" class="menu-item">
        <svg rpl="" fill="currentColor" height="20" icon-name="home-outline" viewBox="0 0 20 20" width="20"
             xmlns="http://www.w3.org/2000/svg"> <!--?lit$51663927$--><!--?lit$51663927$-->
          <path
              d="m17.71 8.549 1.244.832v8.523a1.05 1.05 0 0 1-1.052 1.046H12.73a.707.707 0 0 1-.708-.707v-4.507c0-.76-1.142-1.474-2.026-1.474-.884 0-2.026.714-2.026 1.474v4.507a.71.71 0 0 1-.703.707H2.098a1.046 1.046 0 0 1-1.052-1.043V9.381l1.244-.835v9.158h4.44v-3.968c0-1.533 1.758-2.72 3.27-2.72s3.27 1.187 3.27 2.72v3.968h4.44V8.549Zm2.04-1.784L10.646.655a1.12 1.12 0 0 0-1.28-.008L.25 6.765l.696 1.036L10 1.721l9.054 6.08.696-1.036Z"></path>
          <!--?--> </svg>
        <span>Home</span>
      </a>

      <a href="/popular" class="menu-item">
        <svg rpl="" fill="currentColor" height="20" icon-name="popular-outline" viewBox="0 0 20 20" width="20"
             xmlns="http://www.w3.org/2000/svg"> <!--?lit$51663927$--><!--?lit$51663927$-->
          <path
              d="M10 0a10 10 0 1 0 10 10A10.01 10.01 0 0 0 10 0Zm0 18.75a8.7 8.7 0 0 1-5.721-2.145l8.471-8.471v4.148H14V6.638A.647.647 0 0 0 13.362 6H7.718v1.25h4.148L3.4 15.721A8.739 8.739 0 1 1 10 18.75Z"></path>
          <!--?--> </svg>
        <span>Popular</span>
      </a>

    </div>
    <hr>
    <TopicsMenu/>
    <hr>
  </aside>
</template>

<style scoped>
.sidebar {
  padding-left: 0.75rem;
  padding-right: 0.75rem;
  max-width: 250px;
  padding-top: 1rem;
}

.main-items {
  display: flex;
  flex-direction: column;
}

.menu-item {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  padding-right: 16px;
  min-height: 40px;
  border-radius: 8px;
  padding-left: 1rem;
}

.menu-item {
  font-size: 14px;
  color: #F2F4F5;
}

.menu-item:hover {
  background-color: #131F23;
}

hr {
  width: 100%;
  margin-top: 0.75rem;
  margin-bottom: 0.75rem;
  border: 0 #ffffff1a;
  border-bottom: 1px solid #ffffff33;
  background-color: transparent;
}
</style>
