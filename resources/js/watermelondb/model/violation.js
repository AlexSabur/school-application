import { Model } from '@nozbe/watermelondb'
import { children, date, immutableRelation, readonly, text } from '@nozbe/watermelondb/decorators'

export default class Violation extends Model {
    static table = 'violations'

    static associations = {
        records: { type: 'has_many', foreignKey: 'violation_id' },
    }

    @text('name') name

    @children('students') students

    @readonly @date('created_at') createdAt
    @readonly @date('updated_at') updatedAt
}
