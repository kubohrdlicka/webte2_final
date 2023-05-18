<template>
    <div id="app" ref="document">
        
            <v-container class="fill-height">
                <v-row class="fill-height">
                    <v-col cols="12" class="d-flex align-center justify-center">
                        <div class="content">
                            <v-card width="80%" max-width="1000" class="overflow-auto"
                            
                                style="margin-left: auto; margin-right: auto; ">
                                <div id="component">
                                <v-card-text>
                                    <h1 class="heading">{{ $t('manual.title') }}</h1>
                                </v-card-text>

                                <v-divider />
                                <div v-if="getRole() === 'teacher'">
                                    <TeacherManualComponent />
                                </div>
                                <div v-if="getRole() === 'student'">
                                    <StudentManualComponent />
                                </div>

                            </div>


                            </v-card>
                        </div>
                    </v-col>
                </v-row>
            </v-container>
        
        
        <v-btn class="mx-2" @click="exportToPDF" color="primary">{{ $t('button.savepdf') }}</v-btn>
    </div>
</template>
  
<script>
import html2pdf from "html2pdf.js";
import TeacherManualComponent from '../components/TeacherManualComponent.vue';
import StudentManualComponent from '../components/StudentManualComponent.vue';


export default {
    name: "app",
    methods: {
        getRole() {
            return sessionStorage.getItem('role');
        },
        exportToPDF() {
            let filename;
            if (this.getRole() == 'student') {
                filename = "StudentManual.pdf";
            } else {
                filename = "TeacherManual.pdf";
            }
            html2pdf(document.getElementById("component"), {
                margin: 1,
                width: 100,
                filename: filename,
                image: {
                    type: 'jpeg',
                    quality: 10
                },
                jsPDF: {
                    unit: 'in',
                    format: 'a4',
                    orientation: 'portrait'
                },
                html2canvas: {
                    scale: 1,
                    useCORS: true
                },

            });
        }


    },

    components: {
        TeacherManualComponent,
        StudentManualComponent,
    },

};
</script>
  
<style scoped>
#app {

    text-align: center;
}
</style>