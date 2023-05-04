<template>
    <v-btn variant="plain" @click="setlocale">
        <div v-if="$i18n.locale === 'sk'" class="d-flex align-center"><img class="img" src="../public/en.png" alt=""></div>
        <div v-if="$i18n.locale === 'en'" class="d-flex align-center"><img class="img" src="../public/sk.png" alt=""></div>
    </v-btn>
</template>
  
<script>
import { inject } from 'vue'
import { useI18n } from 'vue-i18n'
// import i18n from "@/i18n"


export default {
    methods:{
        setlocale(){
            if(this.$i18n.locale === 'sk'){
                this.$i18n.locale = 'en'
            }else{
                this.$i18n.locale = 'sk'
            }
        },
        }
    }
    


</script>
  
<style>
.img {
   height: 20px;
   width: 35px;
}
</style>
