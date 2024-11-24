import type { ERoles } from '@/entities/me'
import type { EDepartments, ESpecs } from './enums'
import type { IEmployee } from './interfaces'
import { fetchEmployees } from '../api'

export const module = {
    namespaced: true,
    state: {
        fetchEmployees: '',
        employees: {
            pagination: {
                perPage: 10,
                currentPage: 1,
                total: null,
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
                    perPage: number
                    currentPage: number
                    total: number
                }
                data: {
                    id: string,
                    fio: string,
                    specialization: ESpecs,
                    department: EDepartments,
                    phone: string,
                    link: string,
                    email: string,
                    role: ERoles,
                    office: {
                        id: number,
                        name: string
                    }
                }[]
            },
        ) {
            state.employees.pagination = data.pagination
            state.employees.employees = []

            data.data.map((value) => {
                state.employees.employees.push({
                    employeeId: value.id,
                    employeeFio: value.fio,
                    employeeSpec: value.specialization,
                    employeeDepartment: value.department,
                    employeePhone: value.phone,
                    employeeLink: value.link,
                    employeeEmail: value.email
                })
            })
        },
        setEmployee(state: any, data: IEmployee) {
            state.employee = data
        },
        setPagination(
            state: any,
            data: {
                perPage: number
                currentPage: number
            },
        ) {
            state.employees.pagination.perPage = data.perPage
            state.employees.pagination.currentPage = data.currentPage
        },
    },
    actions: {
        async getEmployees(
            { commit }: any,
            input: {
                filters: any
                pagination: {
                    perPage: number
                    currentPage: number
                }
            },
        ) {
            console.log(input.filters, input.pagination)
            commit('setFetchEmployees', 'PENDING')
            try {
                await fetchEmployees({pagination: input.pagination, filter: input.filters}).then((res) => {
                    if (res.status === 200) {
                        console.log(res.data)
                        commit('setEmployees', res.data)
                        commit('setFetchEmployees', 'SUCCESS')
                    } else {
                        commit('setFetchEmployees', 'ERROR')
                    }
                })
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
                perPage: number
                currentPage: number
            },
        ) {
            commit('setPagination', pagination)
        },
    },
}
