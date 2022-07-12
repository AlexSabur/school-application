<template>
    <div class="container" v-if="report">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-4 d-md-none d-lg-block">
                <div class="card mb-3">
                    <div class="card-body">
                        Отчёт: {{ report.name }}
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-8">

                <div class="card mb-3">
                    <div class="card-header">
                        <router-link :to="{ name: 'report.show', params: { report: report.id } }"
                            class="btn btn-secondary">
                            <b-icon-arrow-left />
                            Назад
                        </router-link>
                    </div>

                    <div class="card-body">
                        <form form @submit.prevent="submit">
                            <record-violation-radio v-model="data.violationId" />

                            <div class="mb-3">
                                <label for="record-message" class="form-label">Сообщение</label>
                                <textarea class="form-control" name="message" id="record-message" rows="3"
                                    aria-describedby="record-message_help" v-model="data.message"></textarea>
                                <div id="record-message_help" class="form-text"></div>
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
import { UseOnline } from '@vueuse/components'
import { BIconPlus, BIconArrowLeft, BIconArrowRight, BIconPencil, BIconEye, BIconDownload, BIconTrash } from 'bootstrap-icons-vue';
import RecordStudentsTable from '@components/record-students-table.vue';
import RecordViolationRadio from '@components/record-violation-radio.vue';
import { database } from '@/watermelondb';

export default {
    components: {
        UseOnline,
        BIconPlus,
        BIconArrowLeft,
        BIconArrowRight,
        BIconPencil,
        BIconEye,
        BIconDownload,
        BIconTrash,
        RecordStudentsTable,
        RecordViolationRadio,
    },
    data: () => ({
        _watcher: null,
        report: null,
        record: null,
        data: {
            message: '',
        }
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
            this.record = null

            this.data.message = ''
            this.data.violationId = null

            const reportId = this.$route.params.report
            const recordId = this.$route.params.record

            if (!reportId || !recordId) {
                return
            }

            const [report, record] = await Promise.all([
                database.get('reports').find(reportId),
                database.get('records').find(recordId),
            ])

            this.report = report
            this.record = record

            this.data.message = record.message
            this.data.violationId = record.violationId
        },
        async submit() {
            await database.write(async () => {
                return await this.record.update(record => {
                    record.message = this.data.message
                    record.violationId = this.data.violationId
                })
            })

            this.$router.push({ name: 'report.show', params: { report: this.report.id } })
        }
    },
}
</script>
