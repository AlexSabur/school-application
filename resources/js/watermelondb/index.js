import { setGenerator } from '@nozbe/watermelondb/utils/common/randomId';
import Database from "@nozbe/watermelondb/Database";
import Classroom from "./model/classroom";
import Student from "./model/student";
import Violation from "./model/violation";
import Report from "./model/report";
import Record from "./model/record";
import uuid from 'uuid-with-v6'
import { adapter } from "./adapter";
export { sync, checkUnsyncedChanges } from './sync';

setGenerator(() => uuid.v6())

export const database = new Database({
    adapter,
    modelClasses: [
        Classroom,
        Student,
        Violation,
        Report,
        Record,
    ],
})
