<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                <div class="card mb-3">
                    <div class="card-body" v-if="record">
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
        record: null,
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
            this.record = null
            this.report = null

            const reportId = this.$route.params.report
            const recordId = this.$route.params.record

            if (!recordId || !reportId) {
                return
            }

            const [report, record] = await Promise.all([
                database.get('reports').find(reportId),
                database.get('records').find(recordId),
            ])

            this.report = report
            this.record = record
        },
        async submit() {
            await database.write(async () => {
                return await this.record.update(record => {
                    record.markAsDeleted()
                })
            })

            this.$router.push({ name: 'report.show', params: { report: this.report.id } })
        }
    }
}
</script>
