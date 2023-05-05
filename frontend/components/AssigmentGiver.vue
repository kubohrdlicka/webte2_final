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
                    \\includegraphics{/sk.png}`,
        };
    },
    computed: {
        htmlContent() {
            this.assigment = this.assigment;
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
                        let img =  this.g.create('img')
                        img.src = src
                        img.className = 'img-fluid'
                        return [img]
                    }
                    
                    
                    return CustomMacros
                }())
            });

            let html = parse(this.assigment, { generator: latex });
            html = html.domFragment();

            return html.firstChild.outerHTML;
        },
    },
};
</script>
  

<style>

.img-fluid {
    max-width: 60%;
    height: auto;
    margin: 0 auto;
}

</style>
