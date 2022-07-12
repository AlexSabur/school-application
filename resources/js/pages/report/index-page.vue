<template>
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-12 col-lg-8">

                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between">
                        <div class="d-flex gap-3 justify-content-start">
                            Отчёты
                        </div>
                        <div class="d-flex gap-3 justify-content-end">
                            <router-link :to="{ name: 'report.create' }" class="btn btn-secondary">
                                <b-icon-plus />
                                Добавить
                            </router-link>
                        </div>
                    </div>

                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Имя</th>
                                    <th scope="col">Записей</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="report in reports" :key="report.id">
                                    <td>{{ report.name }}</td>
                                    <td><report-records-count :report="report" /></td>
                                    <td>
                                        <div class="d-flex gap-1 justify-content-end">
                                            <router-link :to="{ name: 'report.show', params: { report: report.id }}" class="btn btn-accent1 btn-sm btn-icon">
                                                <b-icon-eye />
                                            </router-link>
                                            <report-download :id="report.id" class="btn btn-accent2 btn-sm btn-icon">
                                                <b-icon-download />
                                            </report-download>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- {{ $reports->links() }} -->
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>
<script>
import ReportDownload from '@components/report-download.vue';
import ReportRecordsCount from '@components/report-records-count.vue';
import { BIconPlus, BIconArrowLeft, BIconPencil, BIconEye, BIconDownload, BIconTrash } from 'bootstrap-icons-vue';
import { useObservable } from '@vueuse/rxjs'
import { database } from '@/watermelondb'

export default {
    components: {
        BIconPlus,
        BIconArrowLeft,
        BIconPencil,
        BIconEye,
        BIconDownload,
        BIconTrash,
        ReportDownload,
        ReportRecordsCount,
    },
    setup() {
        return {
            reports: useObservable(database.get('reports').query().observe())
        }
    }
}
</script>
