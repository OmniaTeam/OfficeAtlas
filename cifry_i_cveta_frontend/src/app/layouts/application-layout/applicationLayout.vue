<template>
    <template v-if="router.name === 'auth' || router.name === 'not-found' || router.name === 'editor'">
        <slot />
    </template>
    <template v-else>
        <div class="application-wrapper" style="display: flex; gap: 8px; height: 100dvh; overflow: hidden;">
            <NavBar />
            <div class="application" style="width: 100%">
                <div class="application__container">
                    <slot />
                </div>
            </div>
        </div>
    </template>
</template>

<script lang="ts" setup>
import { NavBar } from '@/widgets'
import { useRoute } from 'vue-router'

const router = useRoute()
</script>

<style lang="scss" scoped>
.application {
    width: 100%;
    background-color: #fff;
    border-radius: 4px 0 0 4px;
    overflow-y: scroll;
    &__container {
        padding: 20px 32px;
    }
}

.application-wrapper {
    background-color: #f5f7fa;
    display: flex;
    gap: 8px;
    height: 100%;
}
</style>
