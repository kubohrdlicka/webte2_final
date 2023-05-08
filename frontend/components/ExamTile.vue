<template>
    <div class="h-wrapper ma-2">
        {{ data.title }} | {{ data.description }} | {{ data.created_at }} | {{ data.end }}| {{ store.role }}

        <v-btn color="primary" v-if="store.role === 'student' && data.earned_points == undefined" @click="take()">{{ $t('generate.exam') }}</v-btn>
        <h2 v-if="data.earned_points != undefined">{{data.earned_points}} / {{data.points}}</h2>
    </div>
</template>
  
<script>
export default {
    name: 'Exam Tile',
    props: {
        data: {
            type: Object,
            required: true,
        },
        active: {
            type: Boolean,
            required: true,
        },
    },
    computed: {
        store() {
            return this.$store.state
        },
    },
    methods: {
        take() {
            this.$router.push({ name: 'exam', params: { id: this.data.id } })
            //redirect to page wehere studend chooses tasks from assigmesnts
            //get from api /api/assigments/info/{id} (id is in props data object)
        }
    },
    mounted() {
        console.log(this.data)
        console.log(this.data.earned_points)
    }

}
</script>
  
<style lang="scss" scoped>
.h-wrapper {
    background-color: rgb(var(--v-theme-primary));
    width: 10rem;
    height: 10rem;
}
</style>
  