import { Model } from '@nozbe/watermelondb'
import { children, date, immutableRelation, readonly, text } from '@nozbe/watermelondb/decorators'

export default class Classroom extends Model {
    static table = 'classrooms'

    static associations = {
        students: { type: 'has_many', foreignKey: 'classroom_id' },
    }

    @text('name') name

    @children('students') students

    @readonly @date('created_at') createdAt
    @readonly @date('updated_at') updatedAt
}
