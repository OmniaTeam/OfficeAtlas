<template>
    <div class="workspace-object">
        <div class="workspace-object__main"></div>
        <div class="workspace-object__second"></div>
    </div>
</template>

<script lang="ts" setup></script>

<style lang="scss" scoped>
.workspace-object {
    display: flex;
    flex-direction: column;
    align-items: center;
    &__main {
        width: 16px;
        height: 16px;
        background-color: #D9D9D9;
        z-index: 1;
    }
    &__second {
        width: 48px;
        height: 16px;
        background-color: #000;
        margin-top: -8px
    }
}
</style>