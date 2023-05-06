<template>
    <div v-html="htmlContent"></div>
</template>
  
<script>
import axios from 'axios';
import { HtmlGenerator, parse } from 'latex.js'



export default {
    name: 'AssigmentGiver',
    props: {
        taskId: Number,
    },
    data() {
        return {
            assigment: null,
    };
},
    async created() {
    try {
        await axios.get(import.meta.env.VITE_URL + '/api/task/' + this.taskId).then((response) => {
            console.log(response)
            this.assigment = response.data.task.instructions
        })
    } catch (e) {
        console.log(e)
    }
},
computed: {
    htmlContent() {
        this.assigment = this.assigment;
        if (this.assigment) {
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
                        img.src = url + '/' + src
                        img.className = 'img-fluid'
                        return [img]
                    }


                    return CustomMacros
                }())
            });

            let html = parse(this.assigment, { generator: latex });
            html = html.domFragment();

            return html.firstChild.outerHTML;
        }
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
