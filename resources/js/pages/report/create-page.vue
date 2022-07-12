<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                <div class="card mb-3">
                    <div class="card-body">
                        <form @submit.prevent="submit">
                            <div class="mb-3">
                                <label for="report-name-field" class="form-label">Имя отчёта</label>
                                <input type="text" name="name" v-model="name" class="form-control" id="report-name-field" aria-describedby="report-name-help">
                                <div id="report-name-help" class="form-text"></div>
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
import dayjs from 'dayjs'
import { database } from '@/watermelondb'
import { BIconArrowLeft } from 'bootstrap-icons-vue';

export default {
    components: {
        BIconArrowLeft,
    },
    data: () => ({
        name: '',
    }),
    created() {
        this.name = dayjs().format('YYYY-MM-DD')
    },
    methods: {
        async submit() {
            const report = await database.write(async () => {
                return await database.get('reports').create(report => {
                    report.name = this.name
                })
            })

            this.$router.push({ name: 'report.show', params: { report: report.id } })
        }
    }
}
</script>
