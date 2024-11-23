import type { App, Plugin } from 'vue'
import type { Position, Transform, Range } from './types'
import { defaultPosition, defaultTransform, defaultRange } from './utils'
import { useDrag, useDragZoom, type UseDragOption, type UseDragZoomOption } from './hooks'

import { vDrag, vDragZoom } from './directives'
import { DragZoomItem } from './components/drag-zoom-item'
import { DragZoomContainer } from './components/drag-zoom-container'

const install = (app: App) => {
  return app
    .component('DragZoomItem', DragZoomItem)
    .component('DragZoomContainer', DragZoomContainer)
    .directive('drag', vDrag)
    .directive('drag-zoom', vDragZoom)
}

const VueDragZoom: Plugin = { install }

export default VueDragZoom
export {
  useDrag,
  useDragZoom,
  vDrag,
  vDragZoom,
  DragZoomItem,
  DragZoomContainer,
  defaultPosition,
  defaultTransform,
  defaultRange
}
export type {
  Position,
  Transform,
  Range,
  UseDragOption,
  UseDragZoomOption
}
