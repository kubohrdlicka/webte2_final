<template>
  <div class="pt-6">
    <div class="d-md-flex justify-space-between">
      <v-card-title>{{ $t('titles.assignmentCreation') }}</v-card-title>
    </div>

    <v-card class="mx-4">
      <div class="pa-4 pb-0">
        <v-form v-model="isFormValid" @submit.prevent>

          
          <!-- to be continued... -->
          <div class="d-flex flex-xs-column flex-md-row">

            <div class="v-col-12 v-col-md-8 v-col-lg-6">
              <div>
                <div class="d-flex align-center">
                  <v-icon color="primary" size="small" class="mr-2">mdi-rename-box-outline</v-icon>
                  <v-card-title class="pa-0 text-primary">{{ $t('titles.assignment') }}</v-card-title>
                </div>
                <v-divider class="pb-3"/>

                <v-text-field v-model="name" :label="$t('assignmentDetails.name')" :rules="textRules"/>
                <v-text-field v-model="description" :label="$t('assignmentDetails.description')" :rules="textRules"/>
              </div>
              
              <div>
                <div class="d-flex align-center">
                  <v-icon color="primary" size="small" class="mr-2">mdi-clock-time-four-outline</v-icon>
                  <v-card-title class="pa-0 text-primary">{{ $t('titles.assignmentTime') }}</v-card-title>
                </div>
                <v-divider class="pb-3"/>

                <v-text-field v-model="start" :label="$t('assignmentDetails.start')" type="datetime-local" :rules="required"/>
                <v-text-field v-model="end" :label="$t('assignmentDetails.end')" type="datetime-local" :rules="required"/>
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
              :rules="selectRequired"
            >
              <template v-slot:selection="{ item }">
                <v-chip class="mr-2 my-1" variant="outlined" color="primary">
                  <v-icon color="primary" class="mr-2">mdi-file-outline</v-icon>
                  <div class="text-surface-variant">{{ item.title }}</div>
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

            <div v-for="i in values">
              <div class="d-flex align-center pt-4 pb-2">
                <v-icon size="small" color="primary" class="ml-2 mr-2">mdi-file</v-icon>
                <v-card-subtitle class="pa-0">{{ i.name }}</v-card-subtitle>
              </div>
              <div class="d-flex flex-wrap align-center">
                <v-text-field class="v-col-6 v-col-md-4 py-0" v-model="i.title" type="text" :label="$t('input.assignmentTitle')" variant="outlined" density="compact" :rules="[requiredRule]"></v-text-field>
                <v-text-field class="v-col-3 v-col-md-2 py-0" v-model="i.points" type="number" :label="$t('input.assignmentPoints')" variant="outlined" density="compact" :rules="[requiredRule, positiveNumber]"></v-text-field>
              </div>
              <v-divider/>
            </div>
          </div>

          <!-- ...some day -->


          <div class="d-flex justify-center pa-4">
            <v-btn class="mx-2" @click="back()">{{ $t('button.cancel') }}</v-btn>
            <v-btn class="mx-2" color="primary" type="submit" @click="submitForm()">{{ $t('button.save') }}</v-btn>
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
      textRules: [
          value => !!value || this.$t('validation.required'),
          value => (value && value.length >= 3) || this.$t('validation.min3Chars'),
      ],
      required: [
          value => !!value || this.$t('validation.required'),
      ],
      selectRequired: [
        value => !!(value && value.length) || this.$t('validation.required')
      ],
      requiredRule: value => !!value || this.$t('validation.required'),
      positiveNumber: value => value >= 0 || this.$t('validation.notNegative'),
      taskBundles: [],
      values: [],
      name: '',
      description: '',
      start: '',
      end: '',
      isFormValid: false,
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
      if (this.isFormValid) {
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
