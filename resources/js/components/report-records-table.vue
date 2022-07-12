<template>
    <div class="card-body table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Класс</th>
                </tr>
            </thead>
            <tbody>
                <template v-for="(classroomRecords, classroomId) in recordsGroupByClassroom" :key="classroomId">
                    <tr>
                        <!-- <td>{{ classroomRecords }}</td> -->
                        <td>
                            <report-records-classroom-title :classroomId="classroomId" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col" style="width: 25%">Ученик</th>
                                        <th scope="col" style="width: 25%">Причина</th>
                                        <th scope="col" class="d-none d-sm-table-cell ">Сообщение</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <report-records-table-item :report="report" :record="record"
                                        v-for="record in classroomRecords" :key="record.id" />
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>
</template>
<script>
import ReportRecordsTableItem from '@components/report-records-table-item.vue'
import { database } from '@/watermelondb'
import { Q } from '@nozbe/watermelondb'
import { onBeforeUnmount, ref } from 'vue';
import ReportRecordsClassroomTitle from './report-records-classroom-title.vue';

export default {
    components: {
    ReportRecordsTableItem,
    ReportRecordsClassroomTitle
},
    props: ['report'],
    setup({ report }) {
        const recordsGroupByClassroom = ref([])

        const records = database.get('records')
            .query(Q.where('report_id', Q.eq(report.id)))
            .observe()
            .subscribe((records) => {
                recordsGroupByClassroom.value = records.group(({ classroomId }) => classroomId)
            })

        onBeforeUnmount(() => {
            records.unsubscribe()
        })

        return {
            report,
            recordsGroupByClassroom,
        }
    }
}
</script>

