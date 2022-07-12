<template>
    <tr>
        <td>{{ classroom.name }}</td>
        <td>{{ studentsCount }}</td>
        <td>{{ studentsWithRecordCount }}</td>
        <td>
            <div class="d-flex gap-3 justify-content-end">
                <router-link
                    :to="{ name: 'report.record.classroom', params: { report: report.id, classroom: classroom.id } }"
                    class="btn btn-accent1 btn-icon btn-sm">
                    <b-icon-arrow-right />
                </router-link>
            </div>
        </td>
    </tr>
</template>
<script>
import { BIconArrowRight } from 'bootstrap-icons-vue';
import { useObservable } from '@vueuse/rxjs'
import { database } from '@/watermelondb'
import { Q } from '@nozbe/watermelondb'

export default {
    components: {
        BIconArrowRight
    },
    props: ['report', 'classroom'],
    setup({ report, classroom }) {
        const studentsCount = database.get('students').query(Q.where('classroom_id', classroom.id)).observeCount()
        const studentsWithRecordCount = database.get('records').query(Q.where('classroom_id', classroom.id), Q.where('report_id', report.id)).observeCount()

        return {
            report,
            classroom,
            studentsCount: useObservable(studentsCount),
            studentsWithRecordCount: useObservable(studentsWithRecordCount),
        }
    }
}
</script>
