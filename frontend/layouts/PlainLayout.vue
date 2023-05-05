<template>
    <UploadZip></UploadZip>
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

import axios from 'axios'

export default {
    name: 'PlainLayout',
    components: {
        ChangeTheme,
        ChangeLanguage,
        UploadZip
        
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