import { EActions } from '@/entities'
import { AddEmployye, AddEquipment, AddOffice, ImportEmployee, ImportEquipment, ImportRecord } from '@/features'
import AddRecord from '@/features/add-record/addRecord.vue'

export const getHeaderFeatures = (route: string, actions: EActions[]) => {
    switch (route) {
        case 'stat': {
            return {
                label: 'Статистика',
                features: [],
            }
        }
        case 'employee': {
            return {
                label: 'Сотрудники',
                features: [
                    actions.includes(EActions.IMPORT_EMPLOYEE) ? ImportEmployee : null,
                    actions.includes(EActions.ADD_EMPLOYEE) ? AddEmployye : null,
                ],
            }
        }
        case 'offices': {
            return {
                label: 'Офисы',
                features: [actions.includes(EActions.ADD_OFFICE) ? AddOffice : null],
            }
        }
        case 'records': {
            return {
                label: 'Записи',
                features: [
                    actions.includes(EActions.IMPORT_RECORD) ? ImportRecord : null,
                    actions.includes(EActions.ADD_RECORD) ? AddRecord : null,
                ],
            }
        }
        case 'scheme': {
            return {
                label: 'Схема офиса',
                features: [],
            }
        }
        case 'warehouse': {
            return {
                label: 'Склад',
                features: [
                    actions.includes(EActions.IMPORT_EQUIPMENT) ? ImportEquipment : null,
                    actions.includes(EActions.ADD_EQUIPMENT) ? AddEquipment : null,
                ],
            }
        }
    }
}
