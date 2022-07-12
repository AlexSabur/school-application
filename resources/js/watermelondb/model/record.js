import { Model } from '@nozbe/watermelondb'
import { children, date, immutableRelation, readonly, text } from '@nozbe/watermelondb/decorators'

export default class Record extends Model {
    static table = 'records'

    static associations = {
        student: { type: 'belongs_to', foreignKey: 'student_id' },
        classroom: { type: 'belongs_to', foreignKey: 'classroom_id' },
        violation: { type: 'belongs_to', foreignKey: 'violation_id' },
        report: { type: 'belongs_to', foreignKey: 'report_id' },
    }

    @text('message') message

    @immutableRelation('student', 'student_id') student
    @text('student_id') studentId
    @immutableRelation('classroom', 'classroom_id') classroom
    @text('classroom_id') classroomId
    @immutableRelation('violation', 'violation_id') violation
    @text('violation_id') violationId
    @immutableRelation('report', 'report_id') report
    @text('report_id') reportId

    @readonly @date('created_at') createdAt
    @readonly @date('updated_at') updatedAt
}
