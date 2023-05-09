<template>
  <div class="pt-6">
    <div class="d-md-flex justify-space-between">
      <v-card-title>{{ $t('titles.assignmentCreation') }}</v-card-title>
    </div>

    <v-card class="mx-4">
      <div class="pa-4 pb-0">
        <v-form ref="form">

          
          <!-- to be continued... -->
          
          <v-text-field v-model="name" :label="$t('assignmentDetails.name')"/>
          <v-text-field v-model="description" :label="$t('assignmentDetails.description')"/>
          
          <v-text-field v-model="start" :label="$t('assignmentDetails.start')" type="datetime-local"/>
          <v-text-field v-model="end" :label="$t('assignmentDetails.end')" type="datetime-local"/>
          
          <v-autocomplete 
            v-model="values"
            :items="taskBundles"
            :item-title="'name'"
            :label="$t('assignmentDetails.taskBundles')"
            return-object
            multiple
          />

          <div v-for="i in values">
            {{i.name}}
            <v-text-field v-model="i.points" type="number" label="Points"></v-text-field>
          </div>

          <!-- ...some day -->


          <div class="d-flex justify-center pa-4">
            <v-btn class="mx-2" @click="back()">{{ $t('button.cancel') }}</v-btn>
            <v-btn class="mx-2" color="primary" @click="submitForm()">{{ $t('button.save') }}</v-btn>
          </div>
        </v-form>
      </div>
    </v-card>

  </div>
</template>

<script>
import apiService from '../services/apiService';

export default {
  name: 'Assignment Creation view',
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
      end: '',
    }
  },
  methods: {
    getTaskBundles() {
      apiService.get('api/taskbundles')
        .then(response => {
          this.taskBundles = response.data
        })
    },
    submitForm() {
      if (this.$refs.form.validate()) {
        console.log(this.name)
        apiService.post('api/assigments/create', {
          name: this.name,
          description: this.description,
          start: this.start,
          end: this.end,
          exams: this.values
        })
        
      }
    },
    back() {
      this.$router.go(-1)
    }
  },
  mounted() {
    this.getTaskBundles()
  },
}
</script>
