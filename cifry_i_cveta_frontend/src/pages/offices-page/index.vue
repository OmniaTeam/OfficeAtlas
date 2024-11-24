<template>
    <AppHeader :role="me.myRole" />
    <div class="page-content">
        <OfficesList />
    </div>
</template>

<script lang="ts" setup>
import type { IMe } from '@/entities'
import { AppHeader, OfficesList } from '@/widgets'
import { computed, onMounted } from 'vue'
import { useStore } from 'vuex'

const store = useStore()

const me = computed<IMe>(() => store.getters['me/getMe'])

onMounted(async () => {
    await store.dispatch('office/getOffices')
})
</script>

<style lang="scss" scoped>
.header-title {
    font-size: 18px;
    font-weight: 500;
    line-height: 26px;
}
</style>
