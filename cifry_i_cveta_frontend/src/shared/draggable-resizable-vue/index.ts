import type { App } from 'vue'

import DraggableResizableVue from './draggable-resizable-vue3/DraggableResizableVue3.vue'
import DraggableResizableContainer from './draggable-resizable-vue3/DraggableResizableContainer.vue'

export { DraggableResizableVue, DraggableResizableContainer }

DraggableResizableVue.install = (app: App) => {
  app.component('DraggableResizableVue', DraggableResizableVue)
  app.component('DraggableResizableContainer', DraggableResizableContainer)
  return app
}

export default DraggableResizableVue
