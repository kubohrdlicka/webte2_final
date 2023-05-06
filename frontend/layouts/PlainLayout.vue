<template>
    <UploadZip></UploadZip>
    <AssigmentGiver task-id="1" />
    <router-view class="content"></router-view>
    <div class="info">
        <ChangeLanguage></ChangeLanguage>
        <ChangeTheme></ChangeTheme>
    </div>
</template>

<script>
import ChangeTheme from '../components/ChangeTheme.vue'
import ChangeLanguage from '../components/ChangeLanguage.vue'
import UploadZip from '../components/UploadZip.vue'
import AssigmentGiver from '../components/AssigmentGiver.vue'

import axios from 'axios'

export default {
    name: 'PlainLayout',
    components: {
        ChangeTheme,
        ChangeLanguage,
        UploadZip,
        AssigmentGiver
        
    },
  

    }


</script>

<style scoped>
.info {
    height: 50px;
    text-align: end;
}

.content {
    height: calc(100vh - 50px);
    /* margin-bottom: 50px; */
}
</style>