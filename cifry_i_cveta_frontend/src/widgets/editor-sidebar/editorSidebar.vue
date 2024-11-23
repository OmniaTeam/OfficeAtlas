<template>
    <div class="editor-sidebar">
        <div>items</div>
        <el-button type="primary"> Сохранить схему </el-button>
    </div>
</template>

<script lang="ts" setup></script>

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
}
</style>
