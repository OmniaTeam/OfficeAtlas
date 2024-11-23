import type { EMaintenanceStatus, EMaintenanceTypes } from '../enums'

export interface IMaintenance {
    maintenanceId: number
    recordId: number
    equipmentId: number
    maintenanceType: EMaintenanceTypes
    maintenanceStatus: EMaintenanceStatus
    maintenanceDescription: string
    maintenanceDatetime: string
}
