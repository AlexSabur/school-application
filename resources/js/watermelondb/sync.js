import { synchronize, hasUnsyncedChanges } from '@nozbe/watermelondb/sync'
import { client } from '@/client'
import { database } from './index'

export async function checkUnsyncedChanges() {
  return await hasUnsyncedChanges({
    database
  })
}

export async function sync() {
    await synchronize({
        database,
        pullChanges: async ({ lastPulledAt, schemaVersion, migration }) => {
            return await client.request({
                method: 'database@pullChanges',
                params: {
                    last_pulled_at: lastPulledAt,
                    schema_version: schemaVersion,
                    migration: migration,
                }
            });
        },
        pushChanges: async ({ changes, lastPulledAt }) => {
            await client.request({
                method: 'database@pushChanges',
                params: {
                    last_pulled_at: lastPulledAt,
                    changes: changes,
                }
            });
        },
    })
}
