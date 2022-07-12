<template>
    <tr>
        <td>{{ student.name }}</td>
        <td>
            <div class="d-flex gap-1 justify-content-end">
                <!-- @if ($student->record)
                <a href="{{ route('report.record.edit', ['report' => $report->id, 'record' => $student->record_id]) }}" class="btn btn-accent2 btn-icon btn-sm">
                    <x-bi-pencil />
                </a>
                @else
                <a href="{{ route('report.record.add', ['report' => $report->id, 'classroom' => $classroom->id, 'student' => $student->id]) }}" class="btn btn-accent1 btn-icon btn-sm">
                    <x-bi-plus />
                </a>
                @endif -->
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <div class="d-flex cols-3 gap-3 justify-content-center">
                <template v-for="violation in violations" :key="violation.id">
                    <button v-if="record?.violationId === violation.id" class="btn btn-sm d-block btn-accent1"
                        @click="quickRemove()">
                        {{ violation.name }}
                    </button>
                    <button v-else class="btn btn-sm d-block btn-accent2" @click="quickSet(violation)">
                        {{ violation.name }}
                    </button>
                </template>
            </div>
        </td>
    </tr>
</template>

<script>
import { database } from '@/watermelondb'
import { useObservable } from '@vueuse/rxjs'
import { onBeforeUnmount, ref } from 'vue'
import { Q } from '@nozbe/watermelondb'

export default {
    components: {

    },
    props: ['report', 'classroom', 'student'],
    setup({ report, classroom, student }) {
        const violations = database.get('violations').query().observe()

        const record = ref(null)

        const recordSubscriber = database.get('records')
            .query(
                Q.where('report_id', report.id),
                Q.where('classroom_id', classroom.id),
                Q.where('student_id', student.id),
            )
            .observeWithColumns([ 'violation_id' ])
            .subscribe(records => {
                record.value = null

                const [item] = records

                record.value = item || null
            })

        onBeforeUnmount(() =>{
            recordSubscriber.unsubscribe()
        })

        const quickSet = async (violation) => {
            await database.write(async () => {
                const records = await database.get('records')
                    .query(
                        Q.where('report_id', report.id),
                        Q.where('classroom_id', classroom.id),
                        Q.where('student_id', student.id),
                    )
                    .fetch()

                const [item] = records

                if (item) {
                    await item.update(record => {
                        record.violationId = violation.id
                    })

                    return
                }

                await database.get('records').create(record => {
                    record.reportId = report.id
                    record.classroomId = classroom.id
                    record.studentId = student.id
                    record.violationId = violation.id
                })
            })
        }

        const quickRemove = async () => {
            await database.write(async () => {
                const records = await database.get('records')
                    .query(
                        Q.where('report_id', report.id),
                        Q.where('classroom_id', classroom.id),
                        Q.where('student_id', student.id),
                    )
                    .fetch()

                for (const record of records) {
                    await record.markAsDeleted()
                }
            })
        }

        return {
            quickSet,
            quickRemove,
            record,
            report,
            classroom,
            student,
            violations: useObservable(violations),
        }
    }
}
</script>
