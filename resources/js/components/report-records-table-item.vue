<template>
    <tr>
        <td>{{ student.name }}</td>
        <td>{{ violation.name }}</td>
        <td class="d-none d-sm-table-cell ">{{ record.message }}</td>
        <td>
            <div class="d-flex gap-1 justify-content-end">
                <router-link
                    :to="{ name: 'report.record.edit', params: { report: report.id, record: record.id } }"
                    class="btn btn-accent2 btn-sm btn-icon">
                    <b-icon-pencil />
                </router-link>
                <router-link
                    :to="{ name: 'report.record.delete', params: { report: report.id, record: record.id } }"
                    class="btn btn-danger btn-sm btn-icon text-white">
                    <b-icon-trash />
                </router-link>
            </div>
        </td>
    </tr>
</template>
<script>
import { database } from '@/watermelondb'
import { useObservable } from '@vueuse/rxjs';
import { BIconPencil, BIconTrash } from 'bootstrap-icons-vue';

export default {
    components: {
        BIconPencil,
        BIconTrash,
    },
    props: ['record', 'report'],
    setup({ record, report }) {
        return {
            record,
            report,
            student: useObservable(database.get('students').findAndObserve(record.studentId)),
            violation: useObservable(database.get('violations').findAndObserve(record.violationId)),
        }
    }
}
</script>

