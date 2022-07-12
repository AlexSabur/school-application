<template>
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-12 col-lg-4 d-none d-lg-block">
                <classroom-list />
            </div>

            <div class="col-12 col-lg-8">

                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between">
                        <div class="d-flex gap-3 justify-content-start">
                            <router-link :to="{ name: 'classroom.index' }" class="btn btn-secondary">
                                <b-icon-arrow-left />
                                Назад
                            </router-link>
                        </div>
                        <div class="d-flex gap-3 justify-content-end">
                            <!--  -->
                        </div>
                    </div>

                    <div class="card-body">
                        <form @submit.prevent="submit">
                            <div class="mb-3">
                                <label for="classroom-name-field" class="form-label">Имя класса</label>
                                <input type="text" name="name" v-model="name" class="form-control" id="classroom-name-field" aria-describedby="classroom-name-help">
                                <div id="classroom-name-help" class="form-text"></div>
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
        name: '',
    }),
    methods: {
        async submit() {
            const classroom = await database.write(async () => {
                return await database.get('classrooms').create(classroom => {
                    classroom.name = this.name
                })
            })

            this.$router.push({ name: 'classroom.show', params: { classroom: classroom.id } })
        }
    }
}
</script>
