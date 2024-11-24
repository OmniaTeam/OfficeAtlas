import { EObjectTypes } from "./enums";
import type { ISchemaobject } from "./interfaces";

export const module = {
    namespaced: true,
    state: {
        fetchObjects: '',
        objects: [] as ISchemaobject[],
        fetchObject: '',
        object: {} as ISchemaobject,
        currentObjects: [
            {
                objectId: 1,
                objectType: EObjectTypes.CABINET,
                objectLocationX: 300,
                objectLocationY: 300,
                objectHeigth: 100,
                objectWeigth: 100,
                objectLevelnum: 1,
                workspace: {},
            },
            {
                objectId: 2,
                objectType: EObjectTypes.WORKSPACE,
                objectLocationX: 500,
                objectLocationY: 800,
                objectHeigth: 24,
                objectWeigth: 48,
                objectLevelnum: 1,
                workspace: {},
            },
        ] as ISchemaobject[]
    },
    getters: {
        getObjects(state: any) {
            return state.objects;
        },
        getObject(state: any) {
            return state.object;
        },
        getCurrentObjects(state: any) {
            return state.currentObjects;
        }
    },
    mutations: {
        setFetchObjects(state: any, data: string) {
            state.fetchObjects = data;
        },
        setFetchObject(state: any, data: string) {
            state.fetchObject = data;
        },
        setObjects(state: any, data: ISchemaobject[]) {
            state.objects = data;
        },
        setObject(state: any, data: ISchemaobject) {
            state.object = data;
        },
        setCurrentObjects(state: any, data: ISchemaobject[]) {
            state.currentObjects = data;
        },
        updateObjectTransform(state: any, { objectId, newTransform }: { objectId: number; newTransform: { objectLocationX: number; objectLocationY: number; } }) {
            const object = state.currentObjects.find((obj: ISchemaobject) => obj.objectId === objectId);
            if (object) {
                object.objectTransform = newTransform;
            }
        },
        setObjectTransform(state: any, { objectId, transform }: { objectId: number; transform: { objectLocationX: number; objectLocationY: number; } }) {
            const object = state.currentObjects.find((obj: ISchemaobject) => obj.objectId === objectId);
            if (object) {
                object.objectTransform = { ...transform };
            }
        }
    },
    actions: {
        async getObjects({ commit }: any, officeId: number) {
            commit('setFetchObjects', 'PENDING');
            try {
                console.log(officeId);
                commit('setFetchObjects', 'SUCCESS');
            } catch (error) {
                commit('setFetchObjects', 'ERROR');
                console.log(error);
            }
        },
        async getObject({ commit }: any, objectId: number) {
            commit('setFetchObjects', 'PENDING');
            try {
                console.log(objectId);
                commit('setFetchObjects', 'SUCCESS');
            } catch (error) {
                commit('setFetchObjects', 'ERROR');
                console.log(error);
            }
        },
        updateCurrentObjects({ commit }: any, objects: ISchemaobject[]) {
            commit('setCurrentObjects', objects);
        },
        updateObjectTransform({ commit }: any, payload: { objectId: number; newTransform: { objectLocationX: number; objectLocationY: number; } }) {
            commit('updateObjectTransform', payload);
        },
        setObjectTransform({ commit }: any, payload: { objectId: number; transform: { objectLocationX: number; objectLocationY: number; } }) {
            commit('setObjectTransform', payload);
        }
    }
}