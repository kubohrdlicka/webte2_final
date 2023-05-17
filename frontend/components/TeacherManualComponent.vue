<template>
    <v-card-text>
        <h2 class="sub-heading">{{ $t('manual.teacherTitle') }}</h2>
    </v-card-text>
    <v-divider />
    <v-card-text>
        <h3 class="sub-heading">{{ $t('manual.teacherAssignments') }}</h3>
        <p class="overflow-visible">{{ $t('manual.teacherAssignmentsText') }}</p>
    </v-card-text>

    <v-card-text>
        <h3 class="sub-heading">{{ $t('manual.teacherCreateAssignment') }}</h3>
        <p class="overflow-visible">{{ $t('manual.teacherCreateAssignmentText') }}</p>
    </v-card-text>

    <v-card-text>
        <h3 class="sub-heading">{{ $t('manual.teacherResultsAssignment') }}</h3>
        <p class="overflow-visible">{{ $t('manual.teacherResultsAssignmentText') }}</p>
    </v-card-text>

    <v-card-text>
        <h3 class="sub-heading">{{ $t('manual.teacherImport') }}</h3>
        <p class="overflow-visible">{{ $t('manual.teacherImportText') }}</p>
    </v-card-text>
</template>