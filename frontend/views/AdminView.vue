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

    <v-dialog v-model="dialogDelete" max-width="500px">
      <v-card>
        
        <div class="d-flex justify-center py-8 hk-big-icon">
          <v-icon class="py-8" color="primary">mdi-account-cancel</v-icon>
        </div>
        <v-card-title class="text-h5 pb-0">{{ $t('messages.askForDelete') }}</v-card-title>
        <v-card-subtitle class="pb-6">{{ $t('messages.actionWillDeleteUser') }}</v-card-subtitle>

        <v-card-actions class="d-flex justify-center">
          <v-btn @click="closeDelete">{{ $t('button.cancel') }}</v-btn>
          <v-btn color="primary" @click="deleteConfirm">{{ $t('button.submit')  }}</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-dialog v-model="dialogEdit" max-width="600px">
      <v-card>

        <div class="d-flex align-center">
          <div class="hk-big-icon pa-8">
            <v-icon color="primary pa-8">mdi-account</v-icon>
          </div>
          <div>
            <v-card-title>{{ itemToEdit.name }}</v-card-title>
            <v-card-subtitle>{{ itemToEdit.email }}</v-card-subtitle>
          </div>
        </div>

        <v-divider class="mx-6"/>

        <div class="px-2">
          <v-card-title class="text-h5 pb-0">{{ $t('messages.changeUser') }}</v-card-title>
          <v-card-subtitle class="pb-6">{{ $t('messages.actionWillChangeRole') }}</v-card-subtitle>
        </div>

        <div class="px-8">
          <v-select v-model="itemToEdit.role" :items="roles" :item-title="'text'" :item-value="'value'"
            :label="$t('input.role')"></v-select>
        </div>

        <v-card-actions class="d-flex justify-end px-6">
          <v-btn class="mx-2" @click="closeEdit">{{ $t('button.cancel') }}</v-btn>
          <v-btn class="mx-2" @click="saveEdit" color="primary">{{ $t('button.save') }}</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
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
      this.dialogEdit = true
      this.itemToEdit = item
    },
    closeEdit() {
      this.dialogEdit = false
      // this.itemToEdit = null
    },
    saveEdit() {
      apiService.post(`/api/account/changerole/${this.itemToEdit.id}`, {role: this.itemToEdit.role})
        .then(() => {
          this.closeEdit()
        })
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
      apiService.delete(`/api/account/deleteuser/${this.itemToDel.id}`)
        .then(() => {
          this.userList = this.userList.filter((item) => item.id !== this.itemToDel.id)
          this.closeDelete()
        })
    },

    getUsers() {
      apiService.get('/api/account/users')
        .then(response => {
          this.userList = response.data
        })
    }
  },
  mounted() {
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
.hk-big-icon {
  * {
    transform: scale(3);
  }
}

</style>
