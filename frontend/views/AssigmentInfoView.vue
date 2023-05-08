<template>
    <div class="h-wrapper ma-2">
      {{ data.title }} | {{ data.description}} | {{data.start}} | {{data.end}}| {{ store.role }}
      <v-if>
        <v-btn color="primary" v-if="store.role === 'student' && active" @click="take()">{{$t('studnet.take')}}</v-btn>
      </v-if>
    </div>
  
  </template>
  
  <script>
import apiService from '../services/apiService';

  export default {
    name: 'Assignment Tile',
    props: {
      data: {
        type: Number,
        required: true,
      },

    },
    computed: {
      store() {
        // return this.$store.state
      },
    },
    methods: {
      take() {
        //redirect to page wehere studend chooses tasks from assigmesnts
        //get from api /api/assigments/info/{id} (id is in props data object)
      }
    },
    mounted(){
        apiService.get('api/asssigments/info/'+this.data).then(Response => {
            this.data = Response.data
          })
    }
  
  }
  </script>
  
  <style lang="scss" scoped>
  .h-wrapper {
    background-color: rgb(var(--v-theme-primary));
    width: 10rem;
    height: 10rem;
  }
  </style>
  