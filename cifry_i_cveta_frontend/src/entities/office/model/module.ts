import type { IOffice } from './interfaces'

export const module = {
    namespaced: true,
    state: {
        fetchOffices: '',
        offices: {
            pagination: {
                limit: 10,
                page: 1,
                totalCount: null,
            },
            offices: [] as IOffice[],
        },

        fetchOffice: '',
        office: {} as IOffice,
    },
    getters: {
        getOffices(state: any) {
            return state.offices
        },
        getOffice(state: any) {
            return state.office
        },
    },
    mutations: {
        setFetchOffices(state: any, data: string) {
            state.fetchOffices = data
        },
        setFetchOffice(state: any, data: string) {
            state.fetchOffice = data
        },
        setOffices(
            state: any,
            data: {
                pagination: {
                    limit: number
                    page: number
                    totalCount: number
                }
                offices: IOffice[]
            },
        ) {
            state.offices.pagination = data.pagination
            state.offices.offices = data.offices
        },
        setOffice(state: any, data: IOffice) {
            state.office = data
        },
        setPagination(
            state: any,
            data: {
                limit: number
                page: number
            },
        ) {
            state.offices.pagination.limit = data.limit
            state.offices.pagination.page = data.page
        },
    },
    actions: {
        async getOffices(
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
            commit('setFetchOffices', 'PENDING')
            try {
                commit('setFetchOffices', 'SUCCESS')
            } catch (error) {
                console.log(error)
                commit('setFetchOffices', 'ERROR')
            }
        },
        async getOffice({ commit }: any, id: number) {
            console.log(id)
            commit('setFetchOffice', 'PENDING')
            try {
                commit('setFetchOffice', 'SUCCESS')
            } catch (error) {
                console.log(error)
                commit('setFetchOffice', 'ERROR')
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
