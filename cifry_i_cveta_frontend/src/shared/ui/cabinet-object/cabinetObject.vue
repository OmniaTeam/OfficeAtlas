<template>
    <div
        :style="`${cabinetStyle.width}, ${cabinetStyle.height}, ${cabinetStyle.border}, ${cabinetStyle.left}, ${cabinetStyle.position}, ${cabinetStyle.top}, ${cabinetStyle.transition}, ${cabinetStyle.width}`"
        class="cabinet"
        @mousedown="startDrag"
        @mousemove="drag"
        @mouseup="stopDrag"
        @mouseleave="stopDrag"
        @mousedown.right.prevent="startResize"
    >
        <div class="cabinet-content"></div>
        <div class="resize-handle" @mousedown.stop.prevent="startResize"></div>
    </div>
</template>

<script lang="ts" setup>
import { ref, computed } from 'vue';

const props = defineProps<{
    initialTransform: { x: number; y: number; scale: number };
    onTransformChange: (transform: { x: number; y: number; scale: number }) => void;
}>();

const isDragging = ref(false);
const isResizing = ref(false);
const startX = ref(0);
const startY = ref(0);
const offsetX = ref(0);
const offsetY = ref(0);
const startWidth = ref(0);
const startHeight = ref(0);

// Устанавливаем фиксированные позиции для объекта
const cabinetStyle = computed(() => ({
    position: 'absolute',
    left: `${props.initialTransform.x}px`,
    top: `${props.initialTransform.y}px`,
    width: `${100 * props.initialTransform.scale}px`, // Пример ширины
    height: `${100 * props.initialTransform.scale}px`, // Пример высоты
    border: '1px solid black',
    backgroundColor: '#f0f0f0',
    transition: 'width 0.2s ease, height 0.2s ease' // Плавный переход при изменении размера
}));

const startDrag = (event: MouseEvent) => {
    isDragging.value = true;
    offsetX.value = event.clientX - props.initialTransform.x;
    offsetY.value = event.clientY - props.initialTransform.y;
};

const drag = (event: MouseEvent) => {
    if (isDragging.value) {
        props.onTransformChange({
            x: event.clientX - offsetX.value,
            y: event.clientY - offsetY.value,
            scale: props.initialTransform.scale // Масштаб остается фиксированным при перемещении
        });
    }
};

const stopDrag = () => {
    isDragging.value = false;
};

const startResize = (event: MouseEvent) => {
    isResizing.value = true;
    startX.value = event.clientX;
    startY.value = event.clientY;
    startWidth.value = parseInt(cabinetStyle.value.width);
    startHeight.value = parseInt(cabinetStyle.value.height);
};

const resize = (event: MouseEvent) => {
    if (isResizing.value) {
        const newWidth = startWidth.value + (event.clientX - startX.value);
        const newHeight = startHeight.value + (event.clientY - startY.value);
        props.onTransformChange({
            x: props.initialTransform.x, // Позиция остается фиксированной
            y: props.initialTransform.y, // Позиция остается фиксированной
            scale: Math.max(newWidth / 100, newHeight / 100), // Пример масштабирования
        });
    }
};

const stopResize = () => {
    isResizing.value = false;
};
</script>

<style scoped>
.cabinet {
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    cursor: move; /* Курсор перемещения */
    border: 1px solid #000
}

.cabinet-content {
    padding: 10px;
}

.resize-handle {
    position: absolute;
    right: 0;
    bottom: 0;
    width: 10px;
    height: 10px;
    background-color: blue; /* Цвет ручки изменения размера */
    cursor: nwse-resize; /* Курсор изменения размера */
}
</style>