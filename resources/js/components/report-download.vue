<template>
    <use-online v-slot="{ isOnline }">
        <button type="button" @click="download" :disabled="!isOnline" :class="class">
            <slot></slot>
        </button>
    </use-online>
</template>

<script>
import { UseOnline } from '@vueuse/components'

export default {
    components: {
        UseOnline,
    },
    props: [
        'class',
        'id',
    ],
    methods: {
        download() {
            const id = this.id
            const a = document.createElement('a')
            a.target = '_blank'
            a.download = id
            a.href = __routes__.reportDownload({ id })
            a.click()
        }
    }
}
</script>
