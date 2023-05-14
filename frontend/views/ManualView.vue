<template>
    <v-card :cols="10" :offset="1">
        <v-list v-model:opened="open">
            <v-list-item prepend-icon="mdi-book-open-blank-variant" :title="$t('manual.title')"></v-list-item>
            <v-list-group value="teacher">
                <template v-slot:activator="{ props }">
                    <v-list-item v-bind="props" prepend-icon="mdi-human-male-board"
                        :title="$t('manual.teacherTitle')"></v-list-item>
                </template>
                <v-list-group value="registerTeacher">
                    <template v-slot:activator="{ props }">
                        <v-list-item v-bind="props" 
                            :title="$t('manual.register')"></v-list-item>
                    </template>
                    Ako sa registrovať


                </v-list-group>
                <v-list-group value="loginTeacher">
                    <template v-slot:activator="{ props }">
                        <v-list-item v-bind="props"
                            :title="$t('manual.login')"></v-list-item>
                    </template>
                    Ako sa prihlásiť

                </v-list-group>
                <v-list-group value="dashboardTeacher">
                    <template v-slot:activator="{ props }">
                        <v-list-item v-bind="props"
                            :title="$t('manual.dashboard')"></v-list-item>
                    </template>
                    Úvodná stránka

                </v-list-group>
                <v-list-group value="assignmentsTeacher">
                    <template v-slot:activator="{ props }">
                        <v-list-item v-bind="props"
                            :title="$t('manual.assignments')"></v-list-item>
                    </template>
                    Zadania

                </v-list-group>
            </v-list-group>

            <v-list-group value="student">
                <template v-slot:activator="{ props }">
                    <v-list-item v-bind="props" prepend-icon="mdi-account-school"
                        :title="$t('manual.studentTitle')"></v-list-item>
                </template>
                <v-list-group value="registerStudent">
                    <template v-slot:activator="{ props }">
                        <v-list-item v-bind="props"
                            :title="$t('manual.register')"></v-list-item>
                    </template>
                    Ako sa registrovať


                </v-list-group>
                <v-list-group value="loginStudent">
                    <template v-slot:activator="{ props }">
                        <v-list-item v-bind="props"
                            :title="$t('manual.login')"></v-list-item>
                    </template>
                    Ako sa prihlásiť

                </v-list-group>
                <v-list-group value="dashboardStudent">
                    <template v-slot:activator="{ props }">
                        <v-list-item v-bind="props"
                            :title="$t('manual.dashboard')"></v-list-item>
                    </template>
                    Úvodná stránka

                </v-list-group>
                <v-list-group value="assignmentsStudent">
                    <template v-slot:activator="{ props }">
                        <v-list-item v-bind="props"
                            :title="$t('manual.assignments')"></v-list-item>
                    </template>
                    Zadania

                </v-list-group>
            </v-list-group>
        </v-list>
    </v-card>
</template>

<script>
export default {
    data: () => ({
        open: ['Users'],
        admins: [
            ['Management', 'mdi-account-multiple-outline'],
            ['Settings', 'mdi-cog-outline'],
        ],
        cruds: [
            ['Create', 'mdi-plus-outline'],
            ['Read', 'mdi-file-outline'],
            ['Update', 'mdi-update'],
            ['Delete', 'mdi-delete'],
        ],
    }),
}
</script>