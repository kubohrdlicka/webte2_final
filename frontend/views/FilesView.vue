<template>
  <div class="pt-6">
    <div class="d-md-flex justify-space-between">
      <v-card-title>{{ $t('titles.filesOverview') }}</v-card-title>
    </div>

    <v-card class="mx-4">
      <div class="pa-4 pb-0">
        <v-card-title class="text-h6 pa-0 pb-4">{{ $t('titles.newFile') }}</v-card-title>

        <v-file-input v-model="file" :label="$t('inputs.fileLabel')" accept=".zip" :loading="false" color="primary"
          variant="outlined" />

        <div class="d-flex justify-end pb-4">
          <v-btn @click="uploadBundle()" color="primary">{{ $t('button.upload') }}</v-btn>
        </div>
      </div>
    </v-card>

    <v-card class="mx-4 mt-6">
      <v-card-title>{{ $t('titles.filesList') }}</v-card-title>

      <v-data-table v-model:items-per-page="itemsPerPage" :headers="headers" :items="fileList" item-value="name"
        class="elevation-1"></v-data-table>
    </v-card>
  </div>
</template>

<script>
import { VDataTable } from 'vuetify/labs/VDataTable'

export default {
  name: 'Fiels view',
  components: {
    VDataTable,
  },
  data() {
    return {
      file: null,
      fileList: [
        { title: 'Neviem' }
      ],
      itemsPerPage: 10,
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
    }
  },
  computed: {
    headers() {
      return [
        { title: '', key: 'prep-icon' },
        { title: this.$t('table.title'), key: 'title' },
      ]
    }
  },
}
</script>

<style lang="scss" scoped></style>
