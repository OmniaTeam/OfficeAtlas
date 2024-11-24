import { getMyActions } from '@/shared'
import { EActions, ERoles } from './enums'
import type { IMe } from './interfaces'
import { fetchMe } from '../api'

export const module = {
    namespaced: true,
    state: {
        fetchMeState: '',
        me: {} as IMe,
        myActions: [] as EActions[],
    },
    getters: {
        getMe(state: any) {
            return state.me
        },
        getMyActions(state: any) {
            return state.myActions
        },
    },
    mutations: {
        setMe(state: any, data: {
            equipmentCopies: any[],
            id: number,
            fio: string,
            specialization: string,
            department: string,
            phone: string,
            link: string,
            email: string,
            role: string,
            office: {
                id: number,
                name: string
            }
        }) {
            state.me.myId = data.id,
            state.me.myRole = data.role
            state.me.myFio = data.fio
            state.me.mySpec = data.specialization
            state.me.myDepartment = data.department
            state.me.myPhone = data.phone
            state.me.myEmail = data.email
            state.me.myLink = data.link
        },
        setFetchMeState(state: any, data: string) {
            state.fetchMeState = data
        },
        setMyActions(state: any, role: ERoles) {
            state.myActions = getMyActions(role)
        },
    },
    actions: {
        async getMe({ commit }: any) {
            commit('setFetchMeState', 'PENDING')
            try {

                await fetchMe().then((res) => {
                    if (res.status === 200) {
                        console.log(res)
                        commit('setMe', res.data)
                        commit('setMyActions', getMyActions(res.data.role))
                        console.log(getMyActions(res.data.role))
                        commit('setFetchMeState', 'SUCCESS')
                    } else {
                        commit('setFetchMeState', 'ERROR')
                    }
                })
            } catch (error) {
                console.error('Failed to fetch me', error)
                commit('setFetchMeState', 'ERROR')
            }
        },
    },
}
