<template>
    <v-text-field v-model="name" :label="$t('assignmentDetails.name')" :rules="rules" hide-details="auto"></v-text-field>
    <v-text-field v-model="description" :label="$t('assignmentDetails.description')" :rules="rules" hide-details="auto"></v-text-field>

    <v-text-field type="datetime-local" v-model="start" :label="$t('assignmentDetails.start')"  :rules="rules" hide-details="auto"></v-text-field>
    <v-text-field type="datetime-local" v-model="end" :label="$t('assignmentDetails.end')"  :rules="rules" hide-details="auto"></v-text-field>

    <v-select v-model="values" :items="taskBundles" :item-title="'name'"  label="Task bundles" return-object
        multiple></v-select>


    <div v-for="i in values">
        {{i.name}}
        <v-text-field v-model="i.points" type="number" :label="$t('assignmentDetails.points')"></v-text-field>
    </div>

    <v-btn @click="check">Check</v-btn>
</template>

<script>
import axios from 'axios'

export default {
    name: 'CreateAssigment',
    components: {
    },
    computed: {

    },
    async created() {
        try {
            await axios.get(import.meta.env.VITE_URL + '/api/taskbundles', { headers: { Authorization: 'Bearer ' + sessionStorage.getItem('token') } }).then((response) => {
                this.taskBundles = response.data
            })
        } catch (e) {
            console.log(e)
        }
    },
    data() {
        return {
            rules: [
                value => !!value || 'Required.',
                value => (value && value.length >= 3) || 'Min 3 characters',
            ],
            taskBundles: [],
            values: [],
            name: '',
            description: '',
            start: '',
            end: ''

        }
    },
    methods: {
        check() {
            try {
                axios.post(import.meta.env.VITE_URL + '/api/assigments/create', {
                    name: this.name,
                    description: this.description,
                    start: this.start,
                    end: this.end,
                    exams: this.values
                }, { headers: { Authorization: 'Bearer ' + sessionStorage.getItem('token') } }).then((response) => {
                })
            } catch (e) {
                console.log(e)
            }
        }

    }
}
</script>

<style>
.toolbar {
    margin-bottom: 1rem;
}

.img {
    /* width: 2rem; */
    height: 3rem;
    /* margin-left: 2rem; */
}
</style>
