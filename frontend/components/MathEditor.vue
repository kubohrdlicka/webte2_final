<template>
    <math-field id="formula" v-model="formula" @input="change" />
    <v-btn @click="printForm">Print Formula</v-btn>
  </template>
  
  <script>
  export default {
    name: "MathEditor",
    data() {
      return {
        formula: "\\sqrt{25}",
      };
    },
    methods: {
      printForm() {
        console.log(this.formula);
      },
      change(event) {
        const input = event.target.value;
        this.formula = input;
      },
    },
  };
  </script>
  
  <style>
    body.ML__fonts-loading .ML__base {
      visibility: visible !important;
    }
  
    .ML__fieldcontainer__field {
      font-size: 35px;
    }
  </style>
  