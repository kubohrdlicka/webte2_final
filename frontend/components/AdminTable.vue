<template>
    <div class="cont">

        <v-data-table :headers="headers" :items="users" class="elevation-1">
            <template v-slot:top>
                <v-toolbar flat>
                    <v-toolbar-title>Users</v-toolbar-title>
                    <v-divider class="mx-4" inset vertical></v-divider>
                    <v-spacer></v-spacer>


                    <v-dialog v-model="dialogDelete" max-width="500px">
                        <v-card>
                            <v-card-title class="text-h5">Are you sure?</v-card-title>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="blue darken-1" text @click="closeDelete">Cancel</v-btn>
                                <v-btn color="blue darken-1" text @click="deleteConfirm">OK</v-btn>
                                <v-spacer></v-spacer>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                </v-toolbar>
            </template>

            <template v-slot:item.actions="{ item }">
                <v-icon size="large" class="me-2" @click="editUser(item.raw)">
                    mdi-pencil
                </v-icon>
                <v-icon size="large" @click="deleteUser(item.raw)">
                    mdi-delete
                </v-icon>
            </template>

        </v-data-table>
    </div>
</template>

<script>
import axios from 'axios'

import { VDataTable } from 'vuetify/labs/VDataTable'


export default {
    name: 'AdminTable',
    components: {
        VDataTable
    }, watch: {
        dialogDelete(val) {
            val || this.closeDelete()
        },
    },
    data() {
        return {
            users: [],
            dialogDelete: false,
            itemToDel: null,
            headers: [
                { title: 'Name', text: 'Name', value: 'name' },
                { title: 'E-mail', text: 'Email', value: 'email' },
                { title: 'Role', text: 'Role', value: 'role' },
                { key: 'actions', sortable: false, align: 'end' }
            ]
        }
    },
    methods: {
        editUser(item) {
            console.log(item)

        },
        deleteUser(item) {
            this.dialogDelete = true
            this.itemToDel = item

        },
        closeDelete(){
            this.dialogDelete = false
            this.itemToDel = null
        },
        async deleteConfirm() {
            console.log(this.itemToDel.id)
            try{
                await axios.delete(import.meta.env.VITE_URL + '/api/account/deleteuser/' + this.itemToDel.id, { headers: { Authorization: 'Bearer ' + sessionStorage.getItem('token') } }).then((response) => {
                    this.users = this.users.filter((item) => item.id !== this.itemToDel.id)
                    this.closeDelete()
                })
            }catch(e){
                console.log(e)
            }
            
        },

    }, async mounted() {
        try {
            await axios.get(import.meta.env.VITE_URL + '/api/account/users', { headers: { Authorization: 'Bearer ' + sessionStorage.getItem('token') } }).then((response) => {
                this.users = response.data
                console.log(this.users)
            })
        } catch (e) {
            console.log(e)
        }



    }



}
</script>

<style>
.cont {
    margin: 16px;
    margin-top: 2rem;
}
</style>