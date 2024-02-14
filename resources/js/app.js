import { createApp } from 'vue'
import App from './App.vue'
import {createRouter, createWebHistory} from "vue-router";
import MainComponent from "./components/content/MainComponent.vue";
import SubmitComponent from "./components/SubmitComponent.vue";
import PostShowComponent from "./components/posts/PostShowComponent.vue";
import UserShowComponent from "./components/users/UserShowComponent.vue";
import CommunityShowComponent from "./components/communities/CommunityShowComponent.vue";
import CommunitySettingsComponent from "./components/communities/CommunitySettingsComponent.vue";
import UserSettingsComponent from "./components/users/UserSettingsComponent.vue";

const routes = [
    { path: '/', component: MainComponent },
    { path: '/submit', component: SubmitComponent },
    { path: '/p/:slug', component: PostShowComponent },
    { path: '/user/:username', component: UserShowComponent },
    { path: '/community/:slug', component: CommunityShowComponent },
    { path: '/community/update/:slug/', component: CommunitySettingsComponent },
    { path: '/profile', component: UserSettingsComponent },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

const app = createApp(App)
    .use(router)
    .mount('#app');

export default app;
