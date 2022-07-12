import { appSchema, tableSchema } from '@nozbe/watermelondb'

export const schema = appSchema({
    version: 1,
    tables: [
        tableSchema({
            name: 'classrooms',
            columns: [
                // { name: 'id', type: 'string', isIndexed: true },
                { name: 'name', type: 'string' },
                { name: 'created_at', type: 'number' },
                { name: 'updated_at', type: 'number' },
            ]
        }),
        tableSchema({
            name: 'students',
            columns: [
                // { name: 'id', type: 'string', isIndexed: true },
                { name: 'name', type: 'string' },
                { name: 'classroom_id', type: 'string', isIndexed: true },
                { name: 'created_at', type: 'number' },
                { name: 'updated_at', type: 'number' },
            ]
        }),
        tableSchema({
            name: 'violations',
            columns: [
                // { name: 'id', type: 'string', isIndexed: true },
                { name: 'name', type: 'string' },
                { name: 'created_at', type: 'number' },
                { name: 'updated_at', type: 'number' },
            ]
        }),
        tableSchema({
            name: 'reports',
            columns: [
                // { name: 'id', type: 'string', isIndexed: true },
                { name: 'name', type: 'string' },
                { name: 'closed_at', type: 'number', isOptional: true },
                { name: 'created_at', type: 'number' },
                { name: 'updated_at', type: 'number' },
            ]
        }),
        tableSchema({
            name: 'records',
            columns: [
                // { name: 'id', type: 'string', isIndexed: true },
                { name: 'message', type: 'string' },
                { name: 'student_id', type: 'string', isIndexed: true },
                { name: 'classroom_id', type: 'string', isIndexed: true },
                { name: 'violation_id', type: 'string', isIndexed: true },
                { name: 'report_id', type: 'string', isIndexed: true },
                { name: 'created_at', type: 'number' },
                { name: 'updated_at', type: 'number' },
            ]
        }),
    ],
})
