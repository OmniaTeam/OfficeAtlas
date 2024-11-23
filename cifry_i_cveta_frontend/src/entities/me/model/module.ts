// import { fetchMe } from "../api";
import { getMyActions } from '@/shared'
import { EActions, ERoles } from './enums'
import type { IMe } from './interfaces'

export const module = {
    namespaced: true,
    state: {
        fetchMeState: '',
        me: {
            myId: 0,
            myRole: ERoles.MANAGER,
        } as IMe,
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
        setMe(state: any, data: IMe) {
            state.me = data
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
                // Делать запрос на получение информации по пользователю
                // Присваивать полученные данные в стейт me
                // Получить все права по полученному role
                commit('setFetchMeState', 'SUCCESS')
            } catch (error) {
                console.error('Failed to fetch me', error)
                commit('setFetchMeState', 'ERROR')
            }
        },
    },
}
