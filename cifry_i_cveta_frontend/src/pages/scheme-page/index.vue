<template>
    <AppHeader :role="me.myRole" />
    <div class="page-content">
        <AppSchema />
    </div>
</template>

<script lang="ts" setup>
import type { IMe } from '@/entities'
import { AppHeader, AppSchema } from '@/widgets'
import { computed } from 'vue'
import { useStore } from 'vuex'

const store = useStore()

const me = computed<IMe>(() => store.getters['me/getMe'])
</script>

<style lang="scss" scoped>
.header-title {
    font-size: 18px;
    font-weight: 500;
    line-height: 26px;
}

.page-content {
    margin-top: 24px;
}
</style>
