<template>
    <div id="app" ref="document">
        <div id="component">
            <ManualComponent />
        </div>
        <button @click="exportToPDF">Export to PDF</button>
    </div>
</template>
  
<script>
import html2pdf from "html2pdf.js";
import ManualComponent from '../components/ManualComponent.vue';

export default {
    name: "app",
    methods: {
        exportToPDF() {
            html2pdf(document.getElementById("component"), {
                margin: 1,
                filename: "Manual.pdf",
                image: {
                    type: 'jpeg',
                    quality: 10
                }
            });
        },
    },

    components: {
        ManualComponent,
    }
};
</script>
  
<style>
#app {
    
    text-align: center;
}
</style>