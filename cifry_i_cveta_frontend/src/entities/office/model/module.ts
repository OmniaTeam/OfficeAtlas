import { fetchOffices } from '../api'
import type { IOffice } from './interfaces'

export const module = {
    namespaced: true,
    state: {
        fetchOffices: '',
        offices: [] as IOffice[],

        fetchOffice: '',
        office: {} as IOffice,

        createOffice: '',
        
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
                id: number,
                name: string,
                address: string,
                numberOfJobs: number,
                numberLevel: number,
                cabinets: any[]
            }[]
        ) {
            state.offices = []
            data.map((value) => {
                state.offices.push({
                    officeId: value.id,
                    officeName: value.name,
                    officeAdress: value.address,
                    officeEmployeenum: value.numberOfJobs,
                    officeLevelsnum: value.numberLevel
                })
            })
        },
        setOffice(state: any, data: {
            id: number,
            name: string,
            address: string,
            numberOfJobs: number,
            numberLevel: number,
            cabinets: any[]
        }) {
            state.office.officeId = data.id
            state.office.officeName = data.name
            state.office.officeAdress = data.address
            state.office.officeEmployeenum = data.numberOfJobs
            state.office.officeLevelsnum = data.numberLevel
        }
    },
    actions: {
        async getOffices({ commit }: any) {
            commit('setFetchOffices', 'PENDING')
            try {
                await fetchOffices().then((resp) => {
                    if (resp.status === 200) {
                        commit('setOffices', resp.data)
                        commit('setFetchOffices', 'SUCCESS')
                    } else {
                        commit('setFetchOffices', 'ERROR')
                    }
                })
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
    },
}
