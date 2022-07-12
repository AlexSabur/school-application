<template>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Класс</th>
                <th scope="col">Учеников</th>
                <th scope="col">Записей</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <record-classroom-table-item :report="report" :classroom="classroom" v-for="classroom in classrooms" :key="classroom.id" />
        </tbody>
    </table>
</template>
<script>
import { BIconArrowRight } from 'bootstrap-icons-vue';
import { useObservable } from '@vueuse/rxjs'
import { database } from '@/watermelondb'
import RecordClassroomTableItem from '@components/record-classroom-table-item.vue';

export default {
    components: {
        BIconArrowRight,
        RecordClassroomTableItem
    },
    props: ['report'],
    setup({ report }) {
        return {
            report,
            classrooms: useObservable(database.get('classrooms').query().observe()),
        }
    }
}
</script>
