<template>
    <el-page-header @back="() => router.go(-1)">
        <template #title>
            <p>Назад</p>
        </template>
        <template #content>
            <p class="header-title">{{ headerInfo?.label }}</p>
        </template>
        <template #extra>
            <div class="flex items-center">
                <component v-for="(feature, index) in headerInfo?.features" :key="index" :is="feature" />
            </div>
        </template>
    </el-page-header>
</template>

<script lang="ts" setup>
import { computed, type PropType } from 'vue'
import { useRouter } from 'vue-router'
import { getHeaderFeatures } from '../lib'
import { getMyActions } from '@/shared'
import type { ERoles } from '@/entities'

const props = defineProps({
    role: {
        type: String as PropType<ERoles>,
        required: true,
    },
})

const router = useRouter()

const headerInfo = computed(() => getHeaderFeatures(router.currentRoute.value.name as string, getMyActions(props.role)))
</script>
