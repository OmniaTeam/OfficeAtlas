import type { IEmployee } from './interfaces'

export const module = {
    namespaced: true,
    state: {
        fetchEmployees: '',
        employees: {
            pagination: {
                limit: 10,
                page: 1,
                totalCount: null,
            },
            employees: [] as IEmployee[],
        },

        fetchEmployee: '',
        employee: {} as IEmployee,
    },
    getters: {
        getEmployees(state: any) {
            return state.employees
        },
        getEmployee(state: any) {
            return state.employee
        },
    },
    mutations: {
        setFetchEmployees(state: any, data: string) {
            state.fetchEmployees = data
        },
        setFetchEmployee(state: any, data: string) {
            state.fetchEmployee = data
        },
        setEmployees(
            state: any,
            data: {
                pagination: {
                    limit: number
                    page: number
                    totalCount: number
                }
                employees: IEmployee[]
            },
        ) {
            state.employees.pagination = data.pagination
            state.employees.employees = data.employees
        },
        setEmployee(state: any, data: IEmployee) {
            state.employee = data
        },
        setPagination(
            state: any,
            data: {
                limit: number
                page: number
            },
        ) {
            state.employees.pagination.limit = data.limit
            state.employees.pagination.page = data.page
        },
    },
    actions: {
        async getEmployees(
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
            commit('setFetchEmployees', 'PENDING')
            try {
                commit('setFetchEmployees', 'SUCCESS')
            } catch (error) {
                console.log(error)
                commit('setFetchEmployees', 'ERROR')
            }
        },
        async getEmployee({ commit }: any, id: number) {
            console.log(id)
            commit('setFetchEmployee', 'PENDING')
            try {
                commit('setFetchEmployee', 'SUCCESS')
            } catch (error) {
                console.log(error)
                commit('setFetchEmployee', 'ERROR')
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
