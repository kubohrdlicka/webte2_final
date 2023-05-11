<template>
  <div class="pt-6">
    <v-select :items="assigments" v-model="select" :label="$t('fancy.select')" item-text="name" item-value="id"></v-select>

    <v-data-table v-if="active" v-model:expanded="expanded" :headers="tableHeaders" :items="tableData" 
       item-key="name" show-expand class="elevation-1">
      <template v-slot:top>
        <v-toolbar flat color="primary">
          <v-toolbar-title >{{ $t('fancy.name')}}</v-toolbar-title>
          <v-spacer></v-spacer>

        </v-toolbar>
      </template>
      <template v-slot:expanded-row="{ columns, item }">
      <tr>
        <td :colspan="columns.length">
          <div v-for="point in item.raw.points">
           


              <h4>{{point.examBundleId.title}}</h4> 
              <div class="d-flex allign-start justify-space-between ">
                {{ point.task[0].solutions }}

                <div>
                  {{ $t('fancy.solutionTitle') }}
                  <assigment-giver :assigment="`$$` + point.student_exam[0].studen_solution + `$$`"></assigment-giver>
                </div>
                {{point.student_exam[0].earned_points}}  / {{point.examBundleId.points}}
              </div> 
            
          </div> 
        </td>
      </tr>
    </template>
    </v-data-table>


    <div>
    </div>
    <div class="d-flex justify-end ma-4">
      <v-btn @click="getCSV()" class="mx-2" color="primary"> {{ $t('button.csv') }}</v-btn>
    </div>
  </div>
</template>

<script>
import { VDataTable } from 'vuetify/labs/VDataTable'
import axios from 'axios'
import apiService from '../services/apiService'
import AssigmentGiver from '../components/AssigmentGiver.vue'

export default {
  name: 'Results view',
  components: {
    VDataTable,
    AssigmentGiver
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
