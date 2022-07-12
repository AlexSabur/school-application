<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                <div class="card mb-3">
                    <div class="card-body" v-if="report">
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
import { database } from '@/watermelondb'
import { BIconArrowLeft } from 'bootstrap-icons-vue';

export default {
    components: {
        BIconArrowLeft,
    },
    data: () => ({
        _watcher: null,
        name: '',
        report: null,
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
            this.report = null

            const reportId = this.$route.params.report

            if (!reportId) {
                return
            }

            const [report] = await Promise.all([
                database.get('reports').find(reportId),
            ])

            this.name = report.name
            this.report = report
        },
        async submit() {
            const report = await database.write(async () => {
                return await this.report.update(report => {
                    report.name = this.name
                })
            })

            this.$router.push({ name: 'report.show', params: { report: report.id } })
        }
    }
}
</script>
