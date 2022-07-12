<template>
    <div class="container" v-if="report && classroom">
        <div class="row justify-content-center">

            <div class="col-12 col-lg-4 d-md-none d-lg-block">
                <div class="card mb-3">
                    <div class="card-body">
                        Отчёт: {{ report.name }}
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-8">

                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between">
                        <div class="d-flex gap-3 justify-content-start">
                            <router-link :to="{ name: 'report.show', params: { report: report.id }}" class="btn btn-secondary">
                                <b-icon-arrow-left />
                                Назад
                            </router-link>
                        </div>
                        <div class="d-flex gap-3 justify-content-start">
                            Ученики
                        </div>
                    </div>

                    <div class="card-body">
                        <record-students-table :report="report" :classroom="classroom" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { UseOnline } from '@vueuse/components'
import { BIconPlus, BIconArrowLeft, BIconArrowRight, BIconPencil, BIconEye, BIconDownload, BIconTrash } from 'bootstrap-icons-vue';
import RecordStudentsTable from '@components/record-students-table.vue';
import { database } from '@/watermelondb';

export default {
    components: {
        UseOnline,
        BIconPlus,
        BIconArrowLeft,
        BIconArrowRight,
        BIconPencil,
        BIconEye,
        BIconDownload,
        BIconTrash,
        RecordStudentsTable,
    },
    data: () => ({
        _watcher: null,
        report: null,
        classroom: null,
    }),
    created() {
        this._watcher = this.$watch(
            () => this.$route.params,
            () => { this.fetchData() },
            { immediate: true }
        )
    },
    beforeUnmount() {
        if (this._watcher) {
            this._watcher()
        }
    },
    methods: {
        async fetchData() {
            this.report = null
            const reportId = this.$route.params.report
            const classroomId = this.$route.params.classroom

            if (!reportId || !classroomId) {
                return
            }

            const [report, classroom] = await Promise.all([
                database.get('reports').find(reportId),
                database.get('classrooms').find(classroomId),
            ])

            this.report = report
            this.classroom = classroom
        }
    },
}
</script>
