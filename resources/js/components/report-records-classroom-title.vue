<template>
    {{ classroom.name }}
</template>

<script>
import { useObservable } from '@vueuse/rxjs'
import { database } from '@/watermelondb'

export default {
    props: [
        'classroomId',
    ],
    setup({ classroomId }) {
        return {
            classroom: useObservable(database.get('classrooms').findAndObserve(classroomId))
        }
    }
}
</script>
