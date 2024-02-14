<script>

import {defineComponent} from "vue";
import SidebarComponent from "../../SidebarComponent.vue";
import ContentComponent from "./ContentComponent.vue";
import CommunityPopularComponent from "../../communities/CommunityPopularComponent.vue";

export default defineComponent({
    components: {ContentComponent, SidebarComponent, CommunityPopularComponent}
})
</script>

<template>
    <div class="container">
        <div class="sections-wrapper">
            <SidebarComponent/>
            <ContentComponent/>
            <CommunityPopularComponent/>
        </div>
    </div>
</template>

<style scoped>
.sections-wrapper {
    display: grid;
    column-gap: 20px;
    grid-template-columns: 250px 1fr 320px;
}
</style>
