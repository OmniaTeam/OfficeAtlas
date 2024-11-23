import type { IMaintenance } from './interfaces'

export const module = {
    namespaced: true,
    state: {
        fetchMaintenances: '',
        maintenances: {
            pagination: {
                limit: 10,
                page: 1,
                totalCount: null,
            },
            maintenance: [] as IMaintenance[],
        },

        fetchMaintenance: '',
        maintenance: {} as IMaintenance,
    },
    getters: {
        getMaintenances(state: any) {
            return state.maintenances
        },
        getMaintenance(state: any) {
            return state.maintenance
        },
    },
    mutations: {
        setFetchMaintenances(state: any, data: string) {
            state.fetchMaintenances = data
        },
        setFetchMaintenance(state: any, data: string) {
            state.fetchMaintenance = data
        },
        setMaintenances(
            state: any,
            data: {
                pagination: {
                    limit: number
                    page: number
                    totalCount: number
                }
                maintenances: IMaintenance[]
            },
        ) {
            state.maintenances.pagination = data.pagination
            state.maintenances.maintenances = data.maintenances
        },
        setMaintenance(state: any, data: IMaintenance) {
            state.maintenance = data
        },
        setPagination(
            state: any,
            data: {
                limit: number
                page: number
            },
        ) {
            state.maintenances.pagination.limit = data.limit
            state.maintenances.pagination.page = data.page
        },
    },
    actions: {
        async getMaintenances(
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
            commit('setFetchMaintenance', 'PENDING')
            try {
                commit('setFetchMaintenances', 'SUCCESS')
            } catch (error) {
                console.log(error)
                commit('setFetchMaintenances', 'ERROR')
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
