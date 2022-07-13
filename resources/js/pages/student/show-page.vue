<template>
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-12 col-lg-4 d-md-none d-lg-block">
                <classroom-list />
            </div>

            <div class="col-12 col-lg-8" v-if="student">
                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between">
                        <div class="d-flex gap-3 justify-content-start">
                            <router-link :to="{ name: 'classroom.show', params: { classroom: student.classroomId } }" class="btn btn-secondary">
                                <b-icon-arrow-left />
                                Назад
                            </router-link>
                        </div>
                        <div class="d-flex gap-3 justify-content-end">
                            <router-link :to="{ name: 'classroom.student.edit', params: { classroom: student.classroomId, student: student.id }}" class="btn btn-secondary">
                                <b-icon-pencil />
                                Редактировать
                            </router-link>
                        </div>
                    </div>

                    <div class="card-body">
                        Студент: {{ student.name }}
                    </div>
                </div>

                <div class="card md-3">
                    <div class="card-body table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <!-- <th scope="col" style="width: 3rem">#</th> -->
                                    <th scope="col" style="width: 25%">Отчёт</th>
                                    <th scope="col" style="width: 25%">Причина</th>
                                    <th scope="col">Сообщение</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <!-- <tbody>
                                    <tr v-for="record in records" :key="record.id">
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>
                                            <router-link class="link-secondary" :to="{ name: 'report.show', params: {report: record.report.id }}">
                                                {{ record.report.name }}
                                            </router-link>
                                        </td>
                                        <td>{{ record.violation.name }}</td>
                                        <td>{{ record.message }}</td>
                                        <td>
                                            <div class="d-flex gap-1 justify-content-end">
                                                <router-link :to="{ name: 'report.record.edit', params: {report: record.report.id, record: record.id }}" class="btn btn-accent2 btn-sm btn-icon">
                                                    <bootstrap-icon icon="pencil" />
                                                </router-link>
                                                <button type="button" class="btn btn-danger btn-sm btn-icon text-white" data-bs-toggle="modal" data-bs-target="#remove-record-modal" data-bs-action="{{ route('report.record.destroy', ['report' => $record->report->id, 'record' => $record->id]) }}">
                                                    <b-icon-trash />
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                            </tbody> -->
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { database } from '@/watermelondb';
import ClassroomList from '@components/classroom-list.vue'
import ModelDelete from '@components/model-delete.vue'
import { BIconArrowLeft, BIconPencil, BIconTrash } from 'bootstrap-icons-vue';

export default {
    components: {
        ClassroomList,
        ModelDelete,
        BIconArrowLeft,
        BIconPencil,
        BIconTrash,
    },
    data: () => ({
        _watcher: null,
        name: '',
        student: null,
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
            this.student = null

            const studentId = this.$route.params.student

            if (!studentId) {
                return
            }

            const [student] = await Promise.all([
                database.get('students').find(studentId),
            ])

            this.student = student
        },
    }
}
</script>
