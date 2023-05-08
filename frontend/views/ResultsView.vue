<template>
  <div class="pt-6">
    Results
  </div>
</template>

<script>
import apiService from '../services/apiService'

export default {
  name: 'Results view',
  methods:{
    getData(){
      apiService.get('/api/assigmentpoints/3').then((response) => {
        console.log(response.data)
      })
    }

  },mounted(){
    this.getData()
  }
}
</script>
