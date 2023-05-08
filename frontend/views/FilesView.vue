<template>
  <div class="pt-6">
    <div class="d-md-flex justify-space-between">
      <v-card-title>{{ $t('titles.filesOverview') }}</v-card-title>
    </div>

    <v-card class="mx-4">
      <div class="pa-4 pb-0">
        <v-card-title class="text-h6 pa-0 pb-4">{{ $t('titles.newFile') }}</v-card-title>

        <v-file-input v-model="file" :label="$t('input.fileLabel')" accept=".zip" :loading="false" color="primary"
          variant="outlined" />

        <div class="d-flex justify-end pb-4">
          <v-btn @click="uploadBundle()" color="primary">{{ $t('button.upload') }}</v-btn>
        </div>
      </div>
    </v-card>

    <v-card class="mx-4 mt-6">
      <v-card-title>{{ $t('titles.filesList') }}</v-card-title>

      <v-container class="v-col-sm-12 v-col-md-10 v-col-lg-8 pb-8">
        <div class="d-flex justify-end my-2">
          <v-text-field variant="outlined" class="v-col-5 pa-0" density="compact" prepend-icon="mdi-magnify" v-model="search"/>
        </div>

        <v-data-table v-model:items-per-page="itemsPerPage" :headers="headers" :items="fileList" item-value="name"
          class="elevation-1 hk-table" :search="search">
          <template v-slot:item.icon="{ item }">
            <v-icon color="primary">mdi-file</v-icon>
          </template>

          <template v-slot:item.created_at="{ item }">
            {{ formatToLocalTime(item.raw.created_at) }}
          </template>

          <template v-slot:no-data>
            <td colspan="3">
              <div class="d-flex align-center justify-center py-8">
                <v-card-subtitle>{{ $t('table.noData') }}</v-card-subtitle>
              </div>
            </td>
          </template>
        </v-data-table>
      </v-container>
    </v-card>
  </div>
</template>

<script>
import { VDataTable } from 'vuetify/labs/VDataTable'
import apiService from '../services/apiService'

export default {
  name: 'Fiels view',
  components: {
    VDataTable,
  },
  data() {
    return {
      file: null,
      fileList: [],
      itemsPerPage: 10,
      search: '',
    }
  },
  methods: {
    async uploadBundle() {
      if (!this.file) {
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
      } catch (e) {
        console.log(e) //TODO file error toast
      }
    },
    getBundles() {
      apiService.get('api/taskbundles')
        .then((response) => {
          this.fileList = response.data
        })
    },
    formatToLocalTime(time) {
      const date = new Date(time)
      return `${date.toLocaleDateString('sk')}  (${date.toLocaleTimeString('sk')})`
    }
  },
  computed: {
    headers() {
      return [
        { title: '', key: 'icon', width: '10%', align: 'end', sortable: false },
        { title: this.$t('table.title'), key: 'name', width: '60%' },
        { title: this.$t('table.created'), key: 'created_at', width: '30%' },
      ]
    }
  },
  mounted() {
    this.getBundles()
  }
}
</script>

<style lang="scss" scoped>
:deep(.v-table__wrapper),
.hk-table {
  background-color: rgb(var(--v-theme-on-surface-variant)) !important;
  * {
    background-color: rgb(var(--v-theme-on-surface-variant)) !important;
  }
  th {
    text-transform: uppercase;
    font-weight: 600 !important;
  }
}
</style>
