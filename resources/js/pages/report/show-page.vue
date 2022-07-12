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
                            Записи
                        </div>
                        <div class="d-flex gap-3 justify-content-end">
                            <report-download :id="report.id" class="btn btn-accent2">
                                <b-icon-download />
                                Скачать
                            </report-download>
                            <router-link :to="{ name: 'report.record.index', params: { report: report.id }}" class="btn btn-secondary">
                                <b-icon-plus />
                                Добавить
                            </router-link>
                        </div>
                    </div>

                    <report-records-table :report="report" />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ReportRecordsTable from '@components/report-records-table.vue';
import ReportDownload from '@components/report-download.vue';
import { UseOnline } from '@vueuse/components'
import { BIconPlus, BIconArrowLeft, BIconPencil, BIconEye, BIconDownload, BIconTrash } from 'bootstrap-icons-vue';
import { database } from '@/watermelondb';

// const sortRecordsByClassrooms = (records) => {
//     console.log(records);
//     return records.sort((a, b) => {
//         const [aRecord] = a;
//         const [bRecord] = b;

//         const [aNumber, aCharter] = numberCharExtracter(aRecord.classroom.name)
//         const [bNumber, bCharter] = numberCharExtracter(bRecord.classroom.name)

//         const numRes = aNumber - bNumber

//         if (0 === numRes) {
//             return aCharter.localeCompare(bCharter)
//         }

//         return numRes;
//     })
// }

export default {
    components: {
        ReportRecordsTable,
        UseOnline,
        BIconPlus,
        BIconArrowLeft,
        BIconPencil,
        BIconEye,
        BIconDownload,
        BIconTrash,
        ReportDownload,
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
    }
}
</script>
