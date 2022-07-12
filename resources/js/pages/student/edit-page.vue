<template>
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-12 col-lg-4 d-none d-lg-block">
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
                        </div>
                    </div>

                    <div class="card-body">
                        <form @submit.prevent="submit">
                            <div class="mb-3">
                                <label for="student-name-field" class="form-label">Имя класса</label>
                                <input type="text" name="name" v-model="name" class="form-control"
                                    id="student-name-field" aria-describedby="student-name-help">
                                <div id="student-name-help" class="form-text"></div>
                            </div>

                            <button type="submit" class="btn btn-primary" data-form-target="button">Сохранить</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
import ClassroomList from '@components/classroom-list.vue'
import { database } from '@/watermelondb'
import { BIconArrowLeft } from 'bootstrap-icons-vue';

export default {
    components: {
        ClassroomList,
        BIconArrowLeft,
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
            this.name = ''
            this.student = null

            const studentId = this.$route.params.student

            if (!studentId) {
                return
            }

            const [student] = await Promise.all([
                database.get('students').find(studentId),
            ])

            this.name = student.name
            this.student = student
        },
        async submit() {
            const student = await database.write(async () => {
                return await this.student.update(student => {
                    student.name = this.name
                })
            })

            this.$router.push({ name: 'classroom.student.show', params: {
                classroom: student.classroomId,
                student: student.id,
            }})
        }
    }
}
</script>
