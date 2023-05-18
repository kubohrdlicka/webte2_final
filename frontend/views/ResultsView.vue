<template>
  <div class="pt-6">
    <div>
      <v-card-title>{{ $t('titles.resultView') }}</v-card-title>
    </div>

    <v-card class="mx-4">
      <div class="pa-4 pb-8">
        <v-select :items="assigments" v-model="select" :label="$t('fancy.select')" item-text="name" item-value="id"></v-select>

        <div v-if="active">
          <div class="d-flex justify-end my-2">
            <v-text-field variant="outlined" class="v-col-5 v-col-md-3 pa-0" density="compact"
              prepend-icon="mdi-magnify" v-model="search" :placeholder="$t('input.search')"/>
          </div>
        
          <v-data-table v-if="active" v-model:expanded="expanded" :headers="tableHeaders" :items="tableData" 
            item-key="name" show-expand class="elevation-1" :search="search">
            <template v-slot:top>
              <v-toolbar flat color="primary">
                <v-toolbar-title >{{ $t('fancy.name')}}</v-toolbar-title>
                <v-spacer></v-spacer>

              </v-toolbar>
            </template>
            <template v-slot:expanded-row="{ columns, item }">
            <tr>
              <td :colspan="columns.length" class="hk-table-expand-cell">
                <div v-for="point in item.raw.points">
                  <div class="d-flex justify-space-between align-center flex-wrap">
                    <div class="d-flex align-center">
                      <v-icon color="primary">mdi-file</v-icon>
                      <v-card-title>{{ point.examBundleId.title }}</v-card-title>
                    </div>
                    <v-card-title class="text-primary">{{point.student_exam[0].earned_points}}  / {{point.examBundleId.points}} {{ $t('examTile.pointSign') }}</v-card-title>
                    <div class="d-flex align-center">
                      <v-card-subtitle>{{ $t('fancy.solutionTitle') }}</v-card-subtitle>
                      <div>
                        <assigment-giver :assigment="`$$` + point.student_exam[0].studen_solution + `$$`"></assigment-giver>
                        <div class="mx-4 py-2">( {{ point.student_exam[0].studen_solution }} )</div>
                      </div>
                    </div>
                  </div>
                  <v-divider class="mb-1"/>
                </div>

                <div v-if="item.raw.points.length === 0" class="d-flex justify-center align-center">
                  <v-card-subtitle>{{ $t('titles.noExamsDone') }}</v-card-subtitle>
                </div>
              </td>
            </tr>
          </template>
          </v-data-table>
        </div>
      </div>
      
      <div class="d-flex justify-end ma-4">
        <v-btn @click="getCSV()" class="mx-2" color="primary"> {{ $t('button.csv') }}</v-btn>
      </div>
    </v-card>

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
      singleExpand: true,
      assigments: [],
      tableData: null,
      active: false,
      select: null,
      search: '',
    }
  },
  computed: {
    tableHeaders() {
      return [
        { title: this.$t('table.name'), key: 'student.name' },
        { title: this.$t('table.surname'), key: 'student.surname' },
        { title: this.$t('table.doneExams'), key: 'points.length' },
        { title: this.$t('table.points'), key: 'sumpoints' },
        { title: this.$t('table.maxPoints'), key: 'totalpoints' },
      ]
    },
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
        this.tableData = response.data
        this.active = true
      })
    }

  }, mounted() {
    this.getData()
  }
}
</script>

<style lang="scss" scoped>
.hk-table-expand-cell {
  background-color: rgb(var(--v-theme-on-surface-variant)) !important;
}
</style>
