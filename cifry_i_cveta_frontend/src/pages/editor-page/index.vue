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
        <EditorSidebar />
        <div class="canvas">
            <!-- Здесь можно разместить элементы, которые вы хотите редактировать -->
        </div>
    </div>
</template>

<script lang="ts" setup>
import { EditorSidebar } from '@/widgets'
import { useRouter } from 'vue-router'

const router = useRouter()
</script>

<style lang="scss" scoped>
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
