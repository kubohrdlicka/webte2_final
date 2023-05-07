<template>
  <div class="pt-6">
    <v-card class="mx-4 mt-6">
      <v-card-title>{{ $t('titles.adminViewTitle') }}</v-card-title>

      <v-container class="v-col-sm-12 v-col-md-10 v-col-lg-8 pb-8">
        <div class="d-flex justify-end my-2">
          <v-text-field variant="outlined" class="v-col-5 pa-0" density="compact" prepend-icon="mdi-magnify" v-model="search"/>
        </div>

        <v-data-table v-model:items-per-page="itemsPerPage" :headers="headers" :items="userList" item-value="name"
          class="elevation-1 hk-table" :search="search">
          <template v-slot:item.icon="{ item }">
            <v-icon color="primary">mdi-file</v-icon>
          </template>

          <template v-slot:no-data>
            <td colspan="4">
              <div class="d-flex align-center justify-center py-8">
                <v-card-subtitle>{{ $t('table.noData') }}</v-card-subtitle>
              </div>
            </td>
          </template>

          <template v-slot:item.actions="{ item }">
            <v-icon size="small" class="me-2" @click="editUser(item.raw)">
              mdi-pencil
            </v-icon>
            <v-icon size="small" @click="deleteUser(item.raw)">
              mdi-delete
            </v-icon>
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
  name: 'Admin view',
  components: {
    VDataTable,
  },
  data() {
    return {
      search: '',
      userList: [],
      roles: [
        { text: 'Admin', value: 'admin' },
        { text: 'Student', value: 'student' },
        { text: 'Teacher', value: 'teacher' },
      ],
      itemsPerPage: 10,
      dialogDelete: false,
      itemToDel: null,
      dialogEdit: false,
      itemToEdit: null,
    }
  },
  computed: {
    headers() {
      return [
        { title: this.$t('table.name'), value: 'name', width: '40%' },
        { title: this.$t('table.email'), value: 'email', width: '25%' },
        { title: this.$t('table.role'), value: 'role', width: '23%' },
        { key: 'actions', sortable: false, align: 'end', width: '12%' },
      ]
    }
  },
  methods: {
    editUser(item) {
      console.log(item)
      this.dialogEdit = true
      this.itemToEdit = item
    },
    closeEdit() {
      this.dialogEdit = false
      // this.itemToEdit = null
    },
    async saveEdit() {
      try {
        await axios.post(import.meta.env.VITE_URL + '/api/account/changerole/'+this.itemToEdit.id, {role: this.itemToEdit.role},{ headers: { Authorization: 'Bearer ' + sessionStorage.getItem('token') } }).then((response) => {
          this.closeEdit()
        })

      } catch (e) {
        console.log(e)
      }
    },

    deleteUser(item) {
      this.dialogDelete = true
      this.itemToDel = item
    },
    closeDelete() {
      this.dialogDelete = false
      this.itemToDel = null
    },
    async deleteConfirm() {
      console.log(this.itemToDel.id)
      try {
        await axios.delete(import.meta.env.VITE_URL + '/api/account/deleteuser/' + this.itemToDel.id, { headers: { Authorization: 'Bearer ' + sessionStorage.getItem('token') } }).then((response) => {
          this.users = this.users.filter((item) => item.id !== this.itemToDel.id)
          this.closeDelete()
        })
      } catch (e) {
        console.log(e)
      }
    },

    async getUsers() {
      await apiService.get('/api/account/userss')
        .then(response => {
          console.log(response);
          this.userList = response.data
        })
    }
  },
  async mounted() {
    this.getUsers()
  },
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
