<template>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Имя</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <record-students-table-item :report="report" :classroom="classroom" :student="student"
                v-for="student in students" :key="student.id" />
        </tbody>
    </table>
</template>

<script>
import { database } from '@/watermelondb';
import RecordStudentsTableItem from '@components/record-students-table-item.vue';
import { useObservable } from '@vueuse/rxjs';
import { Q } from '@nozbe/watermelondb';
export default {
    components: {
        RecordStudentsTableItem
    },
    props: ['report', 'classroom'],
    setup({ report, classroom }) {
        const students = database.get('students').query(Q.where('classroom_id', classroom.id)).observe()

        return {
            report,
            classroom,
            students: useObservable(students),
        }
    }
}
</script>
