<template>
  <div class="pt-6">
    <div class="d-md-flex justify-space-between">
      <v-card-title>{{ $t('titles.assignmentCreation') }}</v-card-title>
    </div>

    <v-card class="mx-4">
      <div class="pa-4 pb-0">
        <v-form ref="form">

          
          <!-- to be continued... -->
          <div class="d-flex flex-xs-column flex-md-row">

            <div class="v-col-12 v-col-md-8 v-col-lg-6">
              <div>
                <div class="d-flex align-center">
                  <v-icon color="primary" size="small" class="mr-2">mdi-rename-box-outline</v-icon>
                  <v-card-title class="pa-0 text-primary">{{ $t('titles.assignment') }}</v-card-title>
                </div>
                <v-divider class="pb-3"/>

                <v-text-field v-model="name" :label="$t('assignmentDetails.name')"/>
                <v-text-field v-model="description" :label="$t('assignmentDetails.description')"/>
              </div>
              
              <div>
                <div class="d-flex align-center">
                  <v-icon color="primary" size="small" class="mr-2">mdi-clock-time-four-outline</v-icon>
                  <v-card-title class="pa-0 text-primary">{{ $t('titles.assignmentTime') }}</v-card-title>
                </div>
                <v-divider class="pb-3"/>

                <v-text-field v-model="start" :label="$t('assignmentDetails.start')" type="datetime-local"/>
                <v-text-field v-model="end" :label="$t('assignmentDetails.end')" type="datetime-local"/>
              </div>
            </div>

            <div class="v-col-12 v-col-md-4 v-col-lg-6">
              <div class="d-flex justify-center mt-8 hk-large-icon-wrapper">
                <v-icon color="primary" class="ma-8">mdi-file-star-four-points</v-icon>
              </div>
            </div>
          
          </div> 
          <div class="v-col-12">
            <div class="d-flex align-center">
              <v-icon color="primary" size="small" class="mr-2">mdi-file-tree</v-icon>
              <v-card-title class="pa-0 text-primary">{{ $t('titles.assignmentTasks') }}</v-card-title>
            </div>
            <v-divider class="pb-3"/>

            <v-autocomplete 
              v-model="values"
              :items="taskBundles"
              :item-title="'name'"
              :label="$t('assignmentDetails.taskBundles')"
              return-object
              multiple
            >
              <template v-slot:selection="{ item }">
                <v-chip class="mr-2 my-1" variant="outlined" color="primary">
                  <v-icon color="primary" class="mr-2">mdi-file-outline</v-icon>
                  <div class="text-black">{{ item.title }}</div>
                </v-chip>
              </template>
            </v-autocomplete>
          </div>

          <div class="v-col-12">
            <div class="d-flex align-center">
              <v-icon color="primary" size="small" class="mr-2">mdi-format-list-bulleted-square</v-icon>
              <v-card-title class="pa-0 text-primary">{{ $t('titles.assignmentPoints') }}</v-card-title>
            </div>
            <v-divider class="pb-3"/>

            <div v-for="i in values" class="d-flex align-center">
              <v-icon color="primary" class="mr-1 mb-5">mdi-file</v-icon>
              <div class="v-col-12 v-col-md-5 v-col-lg-3 py-0">
                <v-text-field v-model="i.points" type="number" :label="i.name" variant="outlined" density="compact"></v-text-field>
              </div>
            </div>
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
        apiService.post('api/assigments/create', {
          name: this.name,
          description: this.description,
          start: this.start,
          end: this.end,
          exams: this.values
        }).then((response) => {
          if(response.status === 200) {
            this.back()
          }
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

<style lang="scss" scoped>
.hk-large-icon-wrapper {
  * {
    transform: scale(4);
  }
}
</style>
