<template>
    <div class="container" v-if="report">
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
                            <router-link :to="{ name: 'report.show', params: { report: report.id } }"
                                class="btn btn-secondary">
                                <b-icon-arrow-left />
                                Назад
                            </router-link>
                        </div>
                        <div class="d-flex gap-3 justify-content-start">
                            Классы
                        </div>
                    </div>

                    <div class="card-body">
                        <record-classroom-table :report="report" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { UseOnline } from '@vueuse/components'
import { BIconPlus, BIconArrowLeft, BIconArrowRight, BIconPencil, BIconEye, BIconDownload, BIconTrash } from 'bootstrap-icons-vue';
import { database } from '@/watermelondb';
import RecordClassroomTable from '@components/record-classroom-table.vue';

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
        RecordClassroomTable
    },
    data: () => ({
        _watcher: null,
        report: null,
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

            if (!reportId) {
                return
            }

            const [report] = await Promise.all([
                database.get('reports').find(reportId),
            ])

            this.report = report
        }
    },
}
</script>
