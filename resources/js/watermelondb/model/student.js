import { Model } from '@nozbe/watermelondb'
import { children, date, immutableRelation, readonly, text } from '@nozbe/watermelondb/decorators'

export default class Student extends Model {
    static table = 'students'

    static associations = {
        classroom: { type: 'belongs_to', foreignKey: 'classroom_id' },
    }

    @text('name') name

    @immutableRelation('classrooms', 'classroom_id') classroom
    @text('classroom_id') classroomId

    @readonly @date('created_at') createdAt
    @readonly @date('updated_at') updatedAt
}
