<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                <div class="card mb-3">
                    <div class="card-body" v-if="report">
                        <form @submit.prevent="submit">
                            <div class="mb-3">
                                <p>Удалить отчёт?</p>
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
            this.report = null

            const reportId = this.$route.params.report

            if (!reportId) {
                return
            }

            const [report] = await Promise.all([
                database.get('reports').find(reportId),
            ])

            this.report = report
        },
        async submit() {
            await database.write(async () => {
                return await this.report.update(report => {
                    report.markAsDeleted()
                })
            })

            this.$router.push({ name: 'report.index' })
        }
    }
}
</script>
