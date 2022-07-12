import { Model } from '@nozbe/watermelondb'
import { children, date, immutableRelation, readonly, text } from '@nozbe/watermelondb/decorators'

export default class Report extends Model {
    static table = 'reports'

    static associations = {
        records: { type: 'has_many', foreignKey: 'report_id' },
    }

    @text('name') name

    @children('records', 'report_id') records

    @date('created_at') closedAt

    @readonly @date('created_at') createdAt
    @readonly @date('updated_at') updatedAt
}
