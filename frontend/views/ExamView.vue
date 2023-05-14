<template>
  <div class="pt-6">
    <v-card class="mx-4 mt-6">
      <v-card-title>{{ $t('titles.exam') }}</v-card-title>

      <v-container class="v-col-sm-12 v-col-md-10 v-col-lg-8 pb-8">
        <div class="contentCenter">
          <div v-html="htmlContent"></div>

          <div class="d-flex justify-start my-4 pt-6">
            <v-chip prepend-icon="mdi-alert-circle-outline" color="warning" closable @click:close="{}">{{ $t('messages.howToWriteAnAnswear') }}</v-chip>
          </div>

          <v-card-subtitle class="pb-1">{{ $t('titles.answear') }}</v-card-subtitle>
          <math-field id="formula" v-model="formula" @input="change" />
        </div>
      </v-container>
      
      <v-container class="v-col-sm-12 v-col-md-10 v-col-lg-8 pb-8">
        <v-btn class="gombicekXD" @click="submit()" color="primary">{{ $t('button.submitExam') }}</v-btn>
      </v-container>
    </v-card>

  </div>


  <v-dialog v-model="confirmSubmit" max-width="500px">

    <v-card>
      
      <div class="d-flex justify-center py-8 hk-big-icon">
        <v-icon color="primary" size="large" class="pa-8">mdi-clipboard-check-outline</v-icon>
      </div>

      <v-card-title class="text-h5 pb-0">{{ $t('messages.askForSubmitExam') }}</v-card-title>
      <v-card-subtitle class=" pb-6">{{ $t('messages.actionWillSubmitExam') }}</v-card-subtitle>

      <v-card-actions class="d-flex justify-center">
        <v-btn @click="confirmSubmit = false">{{ $t('button.cancel') }}</v-btn>
        <v-btn color="primary" @click="submitExam()">{{ $t('button.submit') }}</v-btn>
      </v-card-actions>
    </v-card>

  </v-dialog>
</template>

<script>
import apiService from '../services/apiService'
import { HtmlGenerator, parse } from 'latex.js'



export default {
  name: 'Exam view',
  // props: {
  //   exambundleId: Number,
  // },
  data() {
    return {
      taskId: null,
      task: null,
      formula: "",
      confirmSubmit: false,
    }
  },
  computed: {
    htmlContent() {
      this.task = this.task;
      if (this.task) {
        const latex = new HtmlGenerator({
          hyphenate: false,
          CustomMacros: (function () {
            function CustomMacros(generator) {
              this.g = generator
            }

            var args = CustomMacros.args = {},
              prototype = CustomMacros.prototype


            args['includegraphics'] = ['H', 'k']
            prototype['includegraphics'] = function (src) {
              src = src.split('/').pop()

              let img = this.g.create('img')
              let url = import.meta.env.VITE_URL
              img.src = url + '/api/image/' + src
              img.className = 'img-fluid'
              return [img]
            }


            return CustomMacros
          }())
        });

        let html = parse(this.task, { generator: latex });
        html = html.domFragment();

        return html.firstChild.outerHTML;
      }

    }
  },
  methods: {
    change(event) {
      const input = event.target.value;
      this.formula = input;
    },
    submit(){
      this.confirmSubmit = true;
    },
    submitExam(){
      this.confirmSubmit = false;
      apiService.post(
        "api/result",
        {
          "task_id": this.taskId,
          "exambundle_id": this.$route.params.id,
          "studnet_solution": this.formula,
        }
      ).then(response => {
        if(response.status === 200) {
          this.$router.go(-1)
        }
      })
    }
  },
  async mounted() {
    await apiService.get("/api/generatetask/" + this.$route.params.id).then((response) => {
      console.log(response.data)
      this.taskId = response.data
    })

    apiService.get("/api/task/" + this.taskId).then((response) => {
      console.log(response.data)
      this.task = response.data.task.instructions
      console.log(this.task)
    })

  },

}
</script>

<style lang="scss">
.img-fluid {
  max-width: 60%;
  height: auto;
  margin: 0 auto;
}


body.ML__fonts-loading .ML__base {
  width: 60%;
  visibility: visible !important;
}

#formula {
  width: 70%;
  margin: 0 auto;
}

.ML__fieldcontainer__field {
  font-size: 35px;
}

.contentCenter {
  display: flex;
  justify-content: center;
  text-align: center;
  align-items: center;
  flex-direction: column;
}

.gombicekXD{
  width: 60%;
  margin: 0 auto;
  display: block;}

.hk-big-icon {
  * {
    transform: scale(3);
  }
}

</style>
