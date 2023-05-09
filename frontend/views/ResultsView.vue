<template>
  <div class="pt-6">
    <v-select
      :items="assigments"
      label="Select Assignment"
      item-text="name"
      item-value="id"
    ></v-select>

    //TOTO: add table with results <br>
    //fancy one with infos about assigment u got data on /assigments/info/:id
    <div>
    </div>
    <v-btn @click="getCSV()"> {{$t('table.getsv')}}</v-btn>
  </div>
</template>

<script>
import axios from 'axios'
import apiService from '../services/apiService'

export default {
  name: 'Results view',
  data(){
    return{
      assigments: []
    }
  },
  methods:{
    getData(){
      apiService.get('/api/allassigments').then((response) => {
        this.assigments = response.data
      })
    },
    getCSV(){
      axios({
        url: import.meta.env.VITE_URL + '/api/generatecsv',
        method: 'GET',
        responseType: 'blob', 
        headers: {
          Authorization: 'Bearer ' + sessionStorage.getItem('token')
        }
      }).then((response) => {
        const url = window.URL.createObjectURL(new Blob([response.data]))
        const link = document.createElement('a')
        link.href = url
        link.setAttribute('download', 'file.csv')
        document.body.appendChild(link)
        link.click()
      })
    }

  },mounted(){
    this.getData()
  }
}
</script>
