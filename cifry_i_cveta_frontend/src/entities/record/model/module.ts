import type { IRecord } from './interfaces'

export const module = {
    namespaced: true,
    state: {
        fetchRecords: '',
        records: {
            pagination: {
                limit: 10,
                page: 1,
                totalCount: null,
            },
            records: [] as IRecord[],
        },

        fetchRecord: '',
        record: {} as IRecord,
    },
    getters: {
        getRecords(state: any) {
            return state.records
        },
        getRecord(state: any) {
            return state.record
        },
    },
    mutations: {
        setFetchRecords(state: any, data: string) {
            state.fetchRecords = data
        },
        setFetchRecord(state: any, data: string) {
            state.fetchRecord = data
        },
        setRecords(
            state: any,
            data: {
                pagination: {
                    limit: number
                    page: number
                    totalCount: number
                }
                records: IRecord[]
            },
        ) {
            state.records.pagination = data.pagination
            state.records.records = data.records
        },
        setRecord(state: any, data: IRecord) {
            state.record = data
        },
        setPagination(
            state: any,
            data: {
                limit: number
                page: number
            },
        ) {
            state.records.pagination.limit = data.limit
            state.records.pagination.page = data.page
        },
    },
    actions: {
        async getRecords(
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
            commit('setFetchRecords', 'PENDING')
            try {
                commit('setFetchRecords', 'SUCCESS')
            } catch (error) {
                console.log(error)
                commit('setFetchRecords', 'ERROR')
            }
        },
        async getRecord({ commit }: any, id: number) {
            console.log(id)
            commit('setFetchRecord', 'PENDING')
            try {
                commit('setFetchRecord', 'SUCCESS')
            } catch (error) {
                console.log(error)
                commit('setFetchRecord', 'ERROR')
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
