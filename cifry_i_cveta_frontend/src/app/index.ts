import { createApp } from 'vue'
import { router } from './provides'
import { store } from './provides/store'

import ElementPlus from 'element-plus'
import 'element-plus/dist/index.css'

import App from './App.vue'
import DraggableResizableVue from '@/shared/draggable-resizable-vue'

export const app = createApp(App).use(router).use(store).use(ElementPlus).use(DraggableResizableVue)
