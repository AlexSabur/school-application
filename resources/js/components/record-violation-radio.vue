<template>
    <div class="form-check" v-for="violation in violations">
        <input class="form-check-input" :id="`violation-${violation.id}`" v-model="selected" type="radio" :value="violation.id">
        <label class="form-check-label" :for="`violation-${violation.id}`">{{ violation.name }}</label>
    </div>
</template>

<script>
import { useObservable } from '@vueuse/rxjs'
import { database } from '@/watermelondb'
import { computed } from 'vue'

export default {
    props: ['modelValue'],
    setup(props, { emit }) {
        const selected = computed({
            get: () => props.modelValue,
            set: (value) => emit('update:modelValue', value)
        })

        return {
            selected,
            violations: useObservable(database.get('violations').query().observe())
        }
    }
}
</script>
