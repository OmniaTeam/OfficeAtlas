import { EActions, ERoles } from '@/entities'

export const getMyActions = (role: ERoles) => {
    switch (role) {
        case ERoles.ADMIN: {
            return [
                EActions.ADD_OFFICE,
                EActions.EDIT_OFFICE,
                EActions.DELETE_OFFICE,

                EActions.ADD_EMPLOYEE,
                EActions.EDIT_EMPLOYEE,
                EActions.DELETE_EMPLOYEE,
                EActions.IMPORT_EMPLOYEE,

                EActions.ADD_EQUIPMENT,
                EActions.IMPORT_EQUIPMENT,
                EActions.EDIT_EQUIPMENT,
                EActions.DELETE_EQUIPMENT,
            ]
        }
        case ERoles.MANAGER: {
            return [
                EActions.ADD_EMPLOYEE,
                EActions.EDIT_EMPLOYEE,
                EActions.DELETE_EMPLOYEE,
                EActions.IMPORT_EMPLOYEE,

                EActions.ADD_EQUIPMENT,
                EActions.IMPORT_EQUIPMENT,
                EActions.EDIT_EQUIPMENT,
                EActions.DELETE_EQUIPMENT,
            ]
        }
        case ERoles.SYSADMIN: {
            return [
                EActions.ADD_EQUIPMENT,
                EActions.IMPORT_EQUIPMENT,
                EActions.EDIT_EQUIPMENT,
                EActions.DELETE_EQUIPMENT,

                EActions.ADD_RECORD,
                EActions.IMPORT_RECORD,
                EActions.EDIT_RECORD,
                EActions.DELETE_RECORD,
            ]
        }
        case ERoles.STAFF: {
            return [EActions.ADD_RECORD, EActions.IMPORT_RECORD, EActions.EDIT_RECORD, EActions.DELETE_RECORD]
        }
    }
}
