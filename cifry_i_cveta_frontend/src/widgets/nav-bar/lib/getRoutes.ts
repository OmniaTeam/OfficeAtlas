import { ERoles } from '@/entities'

import { DataAnalysis, OfficeBuilding, User, Files, Document } from '@element-plus/icons-vue'

export const getRoutes = (role: ERoles) => {
    switch (role) {
        case ERoles.ADMIN: {
            return [
                {
                    id: 1,
                    label: 'Статистика',
                    pathName: 'stat',
                    icon: DataAnalysis,
                },
                {
                    id: 2,
                    label: 'Офисы',
                    pathName: 'offices',
                    icon: OfficeBuilding,
                },
                {
                    id: 3,
                    label: 'Сотрудники',
                    pathName: 'employee',
                    icon: User,
                },
                {
                    id: 4,
                    label: 'Склад',
                    pathName: 'warehouse',
                    icon: Files,
                },
            ]
        }
        case ERoles.SYSADMIN: {
            return [
                {
                    id: 1,
                    label: 'Статистика',
                    pathName: 'stat',
                    icon: DataAnalysis,
                },
                {
                    id: 2,
                    label: 'Схема',
                    pathName: 'scheme',
                    icon: OfficeBuilding,
                },
                {
                    id: 3,
                    label: 'Сотрудники',
                    pathName: 'employee',
                    icon: User,
                },
                {
                    id: 4,
                    label: 'Склад',
                    pathName: 'warehouse',
                    icon: Files,
                },
            ]
        }
        case ERoles.MANAGER: {
            return [
                {
                    id: 1,
                    label: 'Заявки',
                    pathName: 'records',
                    icon: Document,
                },
                {
                    id: 2,
                    label: 'Схема',
                    pathName: 'scheme',
                    icon: OfficeBuilding,
                },
                {
                    id: 3,
                    label: 'Сотрудники',
                    pathName: 'employee',
                    icon: User,
                },
                {
                    id: 4,
                    label: 'Склад',
                    pathName: 'warehouse',
                    icon: Files,
                },
            ]
        }
        case ERoles.STAFF: {
            return [
                {
                    id: 1,
                    label: 'Мои заявки',
                    pathName: 'records',
                    icon: Document,
                },
                {
                    id: 2,
                    label: 'Схема',
                    pathName: 'scheme',
                    icon: OfficeBuilding,
                },
                {
                    id: 3,
                    label: 'Коллеги',
                    pathName: 'employee',
                    icon: User,
                },
                {
                    id: 4,
                    label: 'Склад',
                    pathName: 'warehouse',
                    icon: Files,
                },
            ]
        }
    }
}
