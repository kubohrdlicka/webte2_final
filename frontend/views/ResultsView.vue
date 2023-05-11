<template>
  <div class="pt-6">
    <v-select :items="assigments" v-model="select" label="Select Assignment" item-text="name" item-value="id"></v-select>

    //TOTO: add table with results <br>
    //fancy one with infos about assigment u got data on /assigments/info/:id
    //pri vyhreeslovani solutionov treba pred ne a za ne da $$ pri posielani propu do componentu

    <v-data-table v-if="active" v-model:expanded="expanded" :headers="tableHeaders" :items="tableData" 
       item-key="name" show-expand class="elevation-1">
      <template v-slot:top>
        <v-toolbar flat>
          <v-toolbar-title>Expandable Table</v-toolbar-title>
          <v-spacer></v-spacer>

        </v-toolbar>
      </template>
      <template v-slot:expanded-row="{ columns, item }">
      <tr>
        <td :colspan="columns.length">
          <div v-for="point in item.raw.points">
            {{point}}

          </div> 
        </td>
      </tr>
    </template>
    </v-data-table>


    <div>
    </div>
    <v-btn @click="getCSV()"> {{ $t('button.csv') }}</v-btn>
  </div>
</template>

<script>
import { VDataTable } from 'vuetify/labs/VDataTable'
import axios from 'axios'
import apiService from '../services/apiService'

export default {
  name: 'Results view',
  components: {
    VDataTable,
  },
  data() {
    return {
      expanded: [],
      tableHeaders: [
        { title: this.$t('table.name'), value: 'student.name' },
        { title: this.$t('table.surname'), value: 'student.surname' },
        { title: this.$t('table.points'), value: 'sumpoints' },
        { title: this.$t('table.maxPoints'), value: 'totalpoints' },
      ],
      singleExpand: true,
      assigments: [],
      tableData: null,
      active: false,
      select: null,
    }
  },
  watch: {
    select: function (val) {
      this.getAssigmentInfo(val)
    }
  },
  methods: {
    getData() {
      apiService.get('/api/allassigments').then((response) => {
        this.assigments = response.data
      })
    },
    getCSV() {
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
    },
    getAssigmentInfo(id) {
      apiService.get('/api/assigmentpoints/' + id).then((response) => {
        console.log(response.data)
        this.tableData = response.data
        this.active = true
      })
    }

  }, mounted() {
    this.getData()
  }
}
</script>
