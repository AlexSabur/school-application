<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                <div class="card mb-3">
                    <div class="card-body" v-if="classroom">
                        <form @submit.prevent="submit">
                            <div class="mb-3">
                                <p>Удалить класс?</p>
                                <p>Также будут удалены все связанные записи.</p>
                            </div>

                            <button type="submit" class="btn btn-danger" data-form-target="button">Удалить</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { database } from '@/watermelondb'
import { BIconArrowLeft } from 'bootstrap-icons-vue';

export default {
    components: {
        BIconArrowLeft,
    },
    data: () => ({
        _watcher: null,
        classroom: null,
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
            this.classroom = null

            const classroomId = this.$route.params.classroom

            if (!classroomId) {
                return
            }

            const [classroom] = await Promise.all([
                database.get('classrooms').find(classroomId),
            ])

            this.classroom = classroom
        },
        async submit() {
            await database.write(async () => {
                return await this.classroom.update(classroom => {
                    classroom.markAsDeleted()
                })
            })

            this.$router.push({ name: 'classroom.index' })
        }
    }
}
</script>
