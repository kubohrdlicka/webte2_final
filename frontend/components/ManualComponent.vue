<template>
    <v-container class="fill-height">
        <v-row class="fill-height">
            <v-col cols="12" class="d-flex align-center justify-center">
                <div class="content">
                    <v-card width="500" class="overflow-auto">
                        <v-card-text>
                            <h1 class="heading">{{ $t('manual.title') }}</h1>
                        </v-card-text>

                        <v-divider />

                        <v-card-text>
                            <h2 class="sub-heading">{{ $t('manual.teacherTitle') }}</h2>
                        </v-card-text>

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

                        <v-divider />

                        <v-card-text>
                            <h2 class="sub-heading">{{ $t('manual.studentTitle') }}</h2>
                        </v-card-text>

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
                    </v-card>
                </div>
            </v-col>
        </v-row>
    </v-container>
</template>
