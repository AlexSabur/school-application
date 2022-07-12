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
        'classroom',
    ],
    setup({ classroom }) {
        const count = database.get('students')
            .query(Q.where('classroom_id', Q.eq(classroom.id)))
            .observeCount();

        return {
            count: useObservable(count)
        }
    }
}
</script>
