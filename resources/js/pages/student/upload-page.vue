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
                        </div>
                    </div>

                    <div class="card-body" v-if="classroom">
                        <form @submit.prevent="submit">
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" v-model="form.withHeadingRow" type="checkbox" :true-value="1" :false-value="0" id="upload-with-heading-row">
                                    <label class="form-check-label" for="upload-with-heading-row">
                                        Пропустить первую строку
                                    </label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" v-model="form.action" value="reload" id="upload-action-reload">
                                    <label class="form-check-label" for="upload-action-reload">
                                        Перезагрузить <br> <span class="text-danger">Все ученики и всё с ними связанное будет удалено</span>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" v-model="form.action" value="add" id="upload-action-add">
                                    <label class="form-check-label" for="upload-action-add">
                                        Добавить учеников
                                    </label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="upload-file" class="form-label">Файл с учениками</label>
                                <input class="form-control" v-on:change="handleFile($event)" type="file" id="upload-file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                            </div>
                            <use-online v-slot="{ isOnline }">
                                <button type="submit" class="btn btn-primary" :disabled="!isOnline || null === form.file" data-form-target="button">Сохранить</button>
                            </use-online>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
import ClassroomList from '@components/classroom-list.vue'
import { database, sync } from '@/watermelondb'
import { BIconArrowLeft } from 'bootstrap-icons-vue';
import { UseOnline } from '@vueuse/components'

export default {
    components: {
        UseOnline,
        ClassroomList,
        BIconArrowLeft,
    },
    data: () => ({
        _watcher: null,
        classroom: null,
        form: {
            withHeadingRow: 0,
            action: 'add',
            file: null,
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
        handleFile ({ target: { files }}) {
            this.form.file = null;

            if (files.length) {
                [ this.form.file ] = files
            }
        },
        async fetchData() {
            this.form.withHeadingRow = 0;
            this.form.action = 'add';
            this.form.file = null;
            this.classroom = null;

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
            const body = new FormData;

            body.append('with_heading_row', this.form.withHeadingRow);
            body.append('action', this.form.action);
            body.append('file', this.form.file);

            const url = window.__routes__.classroomStudentUpload({ id: this.classroom.id });
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json'
                },
                body,
            })

            await this.sync()

            if (response.ok) {
                this.$router.push({ name: 'classroom.show', params: { classroom: this.classroom.id } })

                return;
            }
        },
        async sync() {
            let synchronization = true
            let timeout = 5
            let attempts = 0

            do {
                try {
                    attempts++;

                    await sync()

                    synchronization = false
                } catch (error) {
                    console.error(error);

                    if (attempts > 3) {
                        window.$reset(true);

                        return;
                    }

                    await (new Promise((resolve) => setTimeout(() => {
                        resolve()
                    }, timeout)))

                    timeout += 3;
                }
            } while (synchronization);
        }
    }
}
</script>
