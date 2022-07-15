<template>
    <form ref="modal" @submit.prevent="submit" class="modal fade" tabindex="-1" aria-labelledby="remove-student-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="remove-student-modal-label">Подтверждение удаления</h5>
                    <button type="button" class="btn-close" @click="dismiss" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <slot>

                    </slot>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="dismiss">Закрыть</button>
                    <use-online v-slot="{ isOnline }">
                        <button type="submit" class="btn btn-primary" :disabled="!isOnline">Удалить</button>
                    </use-online>
                </div>
            </div>
        </div>
    </form>
</template>

<script>
import { UseOnline } from '@vueuse/components'
import { Modal } from 'bootstrap'

export default {
    components: {
        UseOnline
    },
    data: () => ({
        _modal: null,
        _callback: null,
    }),
    emits: ['submit', 'dismiss'],
    mounted() {
        this._modal = new Modal(this.$refs.modal)
    },
    unmounted() {
        this._modal.dispose()

        this._modal = null
        this._callback = null
    },
    methods: {
        open(callback) {
            this._callback = callback
        },
        dismiss() {
            this.$emit('dismiss')
            this._modal.hide()
            this._callback = null
        },
        async submit() {
            this.$emit('submit')
            this._modal.hide()
            if (this._callback !== mill) {
                this._callback()
            }
        }
    }
}
</script>
