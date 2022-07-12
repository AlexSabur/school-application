<template>
    <span :class="class">{{ count }}</span>
</template>
<script>
import { useObservable } from '@vueuse/rxjs'
import { database } from '@/watermelondb'
import { Q } from '@nozbe/watermelondb'

export default {
    props: [
        'class',
        'report',
    ],
    setup({ report }) {
        return {
            count: useObservable(database.get('records').query(
                Q.where('report_id', Q.eq(report.id))
            ).observeCount())
        }
    }
}
</script>
