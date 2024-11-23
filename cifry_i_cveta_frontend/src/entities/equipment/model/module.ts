import type { IEquipment } from './interfaces'

export const module = {
    namespaced: true,
    state: {
        fetchEquipments: '',
        equipments: {
            pagination: {
                limit: 10,
                page: 1,
                totalCount: null,
            },
            equipments: [] as IEquipment[],
        },

        fetchEquipment: '',
        equipment: {} as IEquipment,
    },
    getters: {
        getEquipments(state: any) {
            return state.equipments
        },
        getEquipment(state: any) {
            return state.equipment
        },
    },
    mutations: {
        setFetchEquipments(state: any, data: string) {
            state.fetchEquipments = data
        },
        setFetchEquipment(state: any, data: string) {
            state.fetchEquipment = data
        },
        setEquipments(
            state: any,
            data: {
                pagination: {
                    limit: number
                    page: number
                    totalCount: number
                }
                equipments: IEquipment[]
            },
        ) {
            state.equipments.pagination = data.pagination
            state.equipments.equipments = data.equipments
        },
        setEquipment(state: any, data: IEquipment) {
            state.equipment = data
        },
        setPagination(
            state: any,
            data: {
                limit: number
                page: number
            },
        ) {
            state.equipments.pagination.limit = data.limit
            state.equipments.pagination.page = data.page
        },
    },
    actions: {
        async getEquipments(
            { commit }: any,
            input: {
                filters: any
                pagination: {
                    limit: number
                    page: number
                }
            },
        ) {
            console.log(input.filters, input.pagination)
            commit('setFetchEquipments', 'PENDING')
            try {
                commit('setFetchEquipments', 'SUCCESS')
            } catch (error) {
                console.log(error)
                commit('setFetchEquipments', 'ERROR')
            }
        },
        async getEquipment({ commit }: any, id: number) {
            console.log(id)
            commit('setFetchEquipment', 'PENDING')
            try {
                commit('setFetchEquipment', 'SUCCESS')
            } catch (error) {
                console.log(error)
                commit('setFetchEquipment', 'ERROR')
            }
        },
        updatePagination(
            { commit }: any,
            pagination: {
                limit: number
                page: number
            },
        ) {
            commit('setPagination', pagination)
        },
    },
}
