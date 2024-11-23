import type { ERecordStatuses, ERecordTypes } from '../enums'

export interface IRecord {
    recordId: number
    employeeId: number
    recordType: ERecordTypes
    recordStatus: ERecordStatuses
    recordDescription: string
}
