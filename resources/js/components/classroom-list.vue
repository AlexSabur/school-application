<template>
    <div class="card mb-3">
        <div class="card-header d-flex justify-content-between">
            <div class="d-flex gap-3 justify-content-start">
                Классы
            </div>
            <div class="d-flex gap-3 justify-content-end">
                <router-link :to="{ name: 'classroom.create' }" class="btn btn-sm btn-icon btn-secondary">
                    +
                </router-link>
            </div>
        </div>
        <div class="list-group list-group-flush">
            <router-link v-for="classroom in classrooms" :key="classroom.id" :to="{ name: 'classroom.show', params: { classroom: classroom.id } }" class="list-group-item list-group-item-action d-flex justify-content-between align-items-start">
                <div class="me-auto">
                    <div class="fw-bold">{{ classroom.name }}</div>
                </div>
                <classroom-list-students-count :classroom="classroom" class="badge bg-primary rounded-pill" />
            </router-link>
        </div>
    </div>
</template>

<script>
import ClassroomListStudentsCount from '@components/classroom-list-students-count.vue'
import { useObservable } from '@vueuse/rxjs'
import { database } from '@/watermelondb'

export default {
    components: {
        ClassroomListStudentsCount,
    },
    setup() {
        return {
            classrooms: useObservable(database.get('classrooms').query().observe())
        }
    }
}
</script>
