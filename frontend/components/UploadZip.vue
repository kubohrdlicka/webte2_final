<template>
      <v-file-input v-model="file" :label="$t('uploadZip.chooseFile')" accept=".zip" class="inp"></v-file-input>
            <v-btn class="btn" size="small" icon @click="uploadBundle()">
                <v-icon icon="mdi-upload"></v-icon>
            </v-btn>
    
</template>

<script>
import axios from 'axios'

export default {
    name: 'UploadZip',
    data() {
        return {
            file: null
        }
    },
    computed: {

    },
    methods: {
        async uploadBundle(){
            if(!this.file){
                return
            }

            try {
                await this.file.forEach(f => {
                    let url = import.meta.env.VITE_URL + '/api/upload'
                    let formData = new FormData()
                    formData.append('file', f)
                    axios.post(url, formData, { headers: { Authorization: 'Bearer ' + sessionStorage.getItem('token') } }).then((response) => {
                        console.log(response)
                    })
                    
                });
            }catch(e){
                console.log(e)
            }



        }
    }
}
</script>

<style>
.toolbar {
    margin-bottom: 1rem;
}

.img {
    /* width: 2rem; */
    height: 3rem;
    /* margin-left: 2rem; */
}
</style>
