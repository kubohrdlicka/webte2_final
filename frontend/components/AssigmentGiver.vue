<template>
    <div v-html="htmlContent"></div>
  </template>
  
  <script>
  import { HtmlGenerator, parse } from 'latex.js'
  
  export default {
    name: 'AssigmentGiver',
    data() {
      return {
        assigment: `Nájdite prenosovú funkciu $F(s)=\\dfrac{Y(s)}{W(s)}$ pre systém opísaný blokovou schémou: 
                    \\includegraphics[width= 650, height=500]{/sk.png}`,
      };
    },
    computed: {
      htmlContent() {
        this.assigment = `\\usepackage{graphicx}\n` + `\\begin{document}\n`+this.assigment+`\n\\end{document}`;
        const latex = new HtmlGenerator({ hyphenate: false });
        let html = parse(this.assigment, {generator: latex});
        html = html.domFragment();
        // latex.loadPackage('base');
        // const html = latex.compile(this.texContent).toHTML();
        return html.firstChild.outerHTML;
      },
    },
  };
  </script>
  