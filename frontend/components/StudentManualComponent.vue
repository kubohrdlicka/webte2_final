<template>
    <v-card-text>
        <h2 class="sub-heading">{{ $t('manual.studentTitle') }}</h2>
    </v-card-text>
    <v-divider />
    <v-card-text>
        <h3 class="sub-heading">{{ $t('manual.studentAssignments') }}</h3>
        <p class="overflow-visible">{{ $t('manual.studentAssignmentsText') }}</p>
    </v-card-text>

    <v-card-text>
        <h3 class="sub-heading">{{ $t('manual.studentAssignmentElaborate') }}</h3>
        <p class="overflow-visible">{{ $t('manual.studentAssignmentElaborateText') }}</p>
    </v-card-text>

    <v-card-text>
        <h3 class="sub-heading">{{ $t('manual.studentHistory') }}</h3>
        <p class="overflow-visible">{{ $t('manual.studentHistoryText') }}</p>
    </v-card-text>
</template>