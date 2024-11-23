import type { EEquipmentQuality, EEquipmentStatuses } from '../enums'

export interface IEquipment {
    equipmentId: number //equipmentCopy
    equipmentName: string
    equipmentModel: string
    equipmentSerialnum: string
    equipmentQuality: EEquipmentQuality
    equipmentStatus: EEquipmentStatuses
    equipmentDateby: string
}
