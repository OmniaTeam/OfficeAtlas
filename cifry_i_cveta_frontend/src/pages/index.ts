import Routing from './index.vue'

export const routes = [
    {
        path: '/',
        name: 'auth',
        component: () => import('./auth-page/index.vue'),
    },
    {
        path: '/employee',
        name: 'employee',
        component: () => import('./employee-page/index.vue'),
    },
    {
        path: '/offices',
        name: 'offices',
        component: () => import('./offices-page/index.vue'),
    },
    {
        path: '/records',
        name: 'records',
        component: () => import('./records-page/index.vue'),
    },
    {
        path: '/scheme',
        name: 'scheme',
        component: () => import('./scheme-page/index.vue'),
    },
    {
        path: '/stat',
        name: 'stat',
        component: () => import('./stat-page/index.vue'),
    },
    {
        path: '/warehouse',
        name: 'warehouse',
        component: () => import('./warehouse-page/index.vue'),
    },
    {
        path: '/editor',
        name: 'editor',
        component: () => import('./editor-page/index.vue'),
    },
    {
        path: '/:pathMatch(.*)*',
        name: 'not-found',
        component: () => import('./not-found-page/index.vue'),
    },
]

export { Routing }
