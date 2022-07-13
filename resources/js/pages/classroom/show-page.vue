<template>
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-12 col-lg-4 d-none d-lg-block">
                <classroom-list />
            </div>

            <div class="col-12 col-lg-8" v-if="classroom">

                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between">
                        <div class="d-flex gap-3 justify-content-start">
                            <router-link :to="{ name: 'classroom.index' }" class="btn btn-secondary">
                                <b-icon-arrow-left />
                                Назад
                            </router-link>
                        </div>
                        <div class="d-flex gap-3 justify-content-end">
                            <router-link :to="{ name: 'classroom.edit', params: { classroom: classroom.id } }"
                                class="btn btn-secondary">
                                <b-icon-pencil />
                                Редактировать
                            </router-link>
                        </div>
                    </div>

                    <div class="card-body">
                        Класс: {{ classroom.name }}
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between">
                        <div class="d-flex gap-3 justify-content-start">
                            Ученики
                        </div>
                        <div class="d-flex gap-3 justify-content-end">
                            <router-link :to="{ name: 'classroom.student.upload', params: { classroom: classroom.id } }"
                                class="btn btn-accent2 btn-icon text-white">
                                <b-icon-upload />
                            </router-link>
                            <router-link :to="{ name: 'classroom.student.create', params: { classroom: classroom.id } }"
                                class="btn btn-secondary">
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
                                    <th scope="col">Отчётов</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="student in students" :key="student.id">
                                    <td>{{ student.name }}</td>
                                    <td>{{ student.records_count }}</td>
                                    <td>
                                        <div class="d-flex gap-1 justify-content-end">
                                            <router-link
                                                :to="{ name: 'classroom.student.show', params: { classroom: classroom.id, student: student.id } }"
                                                class="btn btn-accent1 btn-icon btn-sm">
                                                <b-icon-eye />
                                            </router-link>
                                            <router-link
                                                :to="{ name: 'classroom.student.edit', params: { classroom: classroom.id, student: student.id } }"
                                                class="btn btn-accent2 btn-icon btn-sm">
                                                <b-icon-pencil />
                                            </router-link>
                                            <button type="button" disabled class="btn btn-danger btn-sm btn-icon text-white"
                                                data-bs-toggle="modal" data-bs-target="#remove-student-modal"
                                                data-bs-action="{{ route('classroom.student.destroy', ['classroom' => $classroom->id, 'student' => $student->id]) }}">
                                                <b-icon-trash />
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <model-delete>
        <p>Удалить ученика?</p>
        <p>Также будут удалены все связанные записи.</p>
    </model-delete>
</template>

<script>
import classroomList from '@components/classroom-list.vue'
import ModelDelete from '@components/model-delete.vue'
import { BIconArrowLeft, BIconPencil, BIconTrash, BIconEye, BIconPlus, BIconUpload } from 'bootstrap-icons-vue';
import { database } from '@/watermelondb'
import { Q } from '@nozbe/watermelondb'

export default {
    components: {
        classroomList,
        ModelDelete,
        BIconArrowLeft,
        BIconPencil,
        BIconTrash,
        BIconEye,
        BIconPlus,
        BIconUpload,
    },
    data: () => ({
        _watcher: null,
        classroom: null,
        students: [],
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
            const classroomId = this.$route.params.classroom

            if (!classroomId) {
                return
            }

            const [classroom, students] = await Promise.all([
                database.get('classrooms').find(classroomId),
                database.get('students').query(Q.where('classroom_id', Q.eq(classroomId))).fetch(),
            ])

            this.classroom = classroom
            this.students = students
        }
    }
}
</script>
