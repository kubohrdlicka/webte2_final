<template>
  <div class="pt-6">
    <div>
      <v-card-title>{{ $t('titles.adminViewTitle') }}</v-card-title>
    </div>

    <v-card class="mx-4">

      <div class="pa-4 pb-8">
        <div class="d-flex justify-end my-2">
          <v-text-field variant="outlined" class="v-col-5 v-col-md-3 pa-0" density="compact"
            prepend-icon="mdi-magnify" v-model="search" :placeholder="$t('input.search')"/>
        </div>

        <v-data-table v-model:items-per-page="itemsPerPage" :headers="headers" :items="userList" item-value="name"
          class="elevation-1 hk-table" :search="search">
          <template v-slot:item.icon="{ item }">
            <v-icon v-if="item.props.title.role === 'admin'" color="primary">mdi-security</v-icon>
            <v-icon v-else-if="item.props.title.role === 'teacher'" color="primary">mdi-school</v-icon>
            <v-icon v-else-if="item.props.title.role === 'student'" color="primary">mdi-account</v-icon>
          </template>

          <template v-slot:top>
            <v-toolbar flat color="primary">
              <v-toolbar-title >{{ $t('titles.registeredUsers')}}</v-toolbar-title>
            </v-toolbar>
          </template>

          <template v-slot:no-data>
            <td colspan="4">
              <div class="d-flex align-center justify-center py-8">
                <v-card-subtitle>{{ $t('table.noData') }}</v-card-subtitle>
              </div>
            </td>
          </template>

          <template v-slot:item.actions="{ item }">
            <div class="d-flex">  
              <v-icon size="small" class="me-2" @click="editUser(item.raw)">
                mdi-pencil
              </v-icon>
              <v-icon size="small" @click="deleteUser(item.raw)">
                mdi-delete
              </v-icon>
            </div>
          </template>

        </v-data-table>
      </div>
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
            <v-card-title>{{ itemToEdit.name }} {{itemToEdit.surname}}</v-card-title>
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
        { text: this.$t('roles.admin'), value: 'admin' },
        { text: this.$t('roles.student'), value: 'student' },
        { text: this.$t('roles.teacher'), value: 'teacher' },
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
        { key: 'icon', width: '7%', sortable: false },
        { title: this.$t('table.name'), key: 'name', width: '30%' },
        { title: this.$t('table.surname'), key: 'surname', width: '30%' },
        { title: this.$t('table.email'), key: 'email', width: '38%' },
        { title: this.$t('table.role'), key: 'role', width: '20%' },
        { key: 'actions', sortable: false, align: 'end', width: '15%', sortable: false },
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
  th {
    font-weight: 300;
  }
}
.hk-big-icon {
  * {
    transform: scale(3);
  }
}

</style>
