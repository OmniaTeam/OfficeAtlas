<template>
    <div class="editor-wrapper">
        <el-page-header class="scheme-header" @back="() => router.go(-1)">
            <template #title>
                <p>Назад</p>
            </template>
            <template #content>
                <p class="header-title">Редактирование карты</p>
            </template>
        </el-page-header>
        <div class="editor-sidebar">
            <div class="editor-sidebar__actions">
                <el-button class="editor-sidebar__actions-button" @click="add('WORKSPACE' as EObjectTypes)"> Рабочее место </el-button>
                <el-button class="editor-sidebar__actions-button" @click="add('CABINET' as EObjectTypes)"> Кабинет </el-button>
            </div>
            <div class="editor-sidebar__footer">
                <el-button class="editor-sidebar__footer-button" type="default" @click=""> Сбросить </el-button>
                <el-button class="editor-sidebar__footer-button" type="primary"> Сохранить схему </el-button>
            </div>
        </div>
        <draggable-resizable-container
            :grid="[20, 20]"
            :show-grid="true"
            class="canvas"
        >
            <draggable-resizable-vue
                v-for="(object, index) in items"
                :key="index"
                v-model:x="object.objectLocationX"
                v-model:y="object.objectLocationY"
                v-model:h="object.objectHeigth"
                v-model:w="object.objectWeigth"
                v-model:active="elementOne.isActive"
                style="border: 1px solid #000"
                :handles-size="20"
                :resizable="object.objectType === 'WORKSPACE' ? false : true"
            >
                <WorkspaceObject v-if="object.objectType === 'WORKSPACE'" />
            </draggable-resizable-vue>
        </draggable-resizable-container>
        <!-- <drag-zoom-container class="canvas" v-model="viewTransform" :zoomRange="{ max: 3, min: 0.6, step: 0.2}">
            <template #fixed>
            </template>
            <drag-zoom-item
                class="draggable"
                v-for="(item, index) in items"
                :key="item.objectId"
                v-model="item.objectTransform"
                @contextmenu.prevent="removeItem(index)"
            >
                <WorkspaceObject v-if="item.objectType === 'WORKSPACE'" :key="index" />
                <CabinetObject v-else-if="item.objectType === 'CABINET'" :initialTransform="item.objectTransform" :onTransformChange="(transform: Transform) => (item.objectTransform as Transform) = transform" />
            </drag-zoom-item> 
        </drag-zoom-container>-->
    </div>
</template>

<script lang="ts" setup>
import type { IWorkspace } from '@/entities';
import { EObjectTypes, type ISchemaobject } from '@/entities/schema-object';
import { WorkspaceObject } from '@/shared';
import { computed, ref, reactive, onMounted, watch } from 'vue';
import { useRouter } from 'vue-router';
import { useStore } from 'vuex';

const store = useStore();
const router = useRouter();

const elementOne = ref({
    x: 400,
    y: 300,
    width: 200,
    height: 200,
    zIndex: 2,
    isActive: true,
})

const element = ref({
    x: 500,
    y: 300,
    width: 48,
    height: 24,
    isActive: false,
})

const objects = computed<ISchemaobject[]>(() => store.getters['object/getCurrentObjects']);

const items = reactive<ISchemaobject[]>([]);

const counter = ref(objects.value.length);
const add = (type: EObjectTypes) => {
    items.push({
        objectId: counter.value += 1,
        objectType: type,
        objectLevelnum: 0,
        workspace: {} as IWorkspace,
        objectLocationX: 500,
        objectLocationY: 500,
        objectHeigth: type === EObjectTypes.WORKSPACE ? 24 : 100,
        objectWeigth: type === EObjectTypes.WORKSPACE ? 48 : 100
    });
};

// Функция для удаления элемента
const removeItem = (index: number) => {
    items.splice(index, 1); // Удаляем элемент по индексу
};

watch(
    items,
    (newVal) => {
        console.log(newVal);
    }
);

onMounted(() => {
    objects.value.map((value) => {
        items.push(value)
    });
});
</script>

<style lang="scss" scoped>
.editor-sidebar {
    position: fixed;
    top: 96px;
    bottom: 16px;
    left: 16px;
    background-color: #fff;
    border-radius: 4px;
    padding: 24px 16px;
    z-index: 9999;
    box-shadow: 0 0px 8px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    &__actions {
        display: flex;
        flex-direction: column;
        gap: 4px;
        &-button {
            width: 100%;
            margin: 0 !important;
        }
    }
    &__footer {
        display: flex;
        flex-direction: column;
        gap: 4px;
        &-button {
            width: 100%;
            margin: 0 !important;
        }
    }
}

.draggable {
    cursor: move;
}

.editor-wrapper {
    position: relative;
    width: 100%;
    height: 100vh;
    overflow: auto;
    &::-webkit-scrollbar {
        display: none;
    }
}

.scheme-header {
    position: fixed;
    top: 8px;
    left: 0;
    right: 0;
    padding: 20px 32px;
    margin: 16px 16px;
    border-radius: 4px;
    background-color: #fff;
    z-index: 9999;
    box-shadow: 0 0px 8px rgba(0, 0, 0, 0.2);
}

.canvas {
    position: relative;
    width: 200%;
    height: 200%;
    background-image: linear-gradient(to right, #e0e0e0 1px, transparent 1px),
        linear-gradient(to bottom, #e0e0e0 1px, transparent 1px);
    background-size: 20px 20px;
}

.canvas::-webkit-scrollbar {
    display: none;
}

.canvas:active {
    cursor: grabbing;
}
</style>