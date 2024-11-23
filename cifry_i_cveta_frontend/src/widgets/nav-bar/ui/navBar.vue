<template>
    <el-menu
        class="navigation-bar"
        :default-active="routes.find((route) => route.pathName === currentRoute.name)?.id"
        :collapse="isCollapse"
    >
        <div>
            <el-menu-item @click="isCollapse = !isCollapse">
                <template v-if="isCollapse">
                    <el-icon style="color: #606266"><CaretRight /></el-icon>
                </template>
                <template v-else>
                    <el-icon style="color: #606266"><CaretLeft /></el-icon>
                </template>
            </el-menu-item>
            <el-menu-item
                v-for="(route, index) in routes"
                :key="index"
                :index="route.id"
                @click="navigateTo(route.pathName)"
            >
                <el-icon><component :is="route.icon" /></el-icon>
                <template #title>
                    <span>{{ route.label }}</span>
                </template>
            </el-menu-item>
        </div>
        <div>
            <el-menu-item :index="routes.length + 1">
                <el-icon><Setting /></el-icon>
                <template #title>
                    <span>Настройки</span>
                </template>
            </el-menu-item>
            <el-menu-item>
                <el-icon><UserFilled /></el-icon>
                <template #title>
                    <span style="overflow: hidden; text-overflow: ellipsis">Имя пользователя №{{ me.myId }}</span>
                </template>
            </el-menu-item>
        </div>
    </el-menu>
</template>

<script lang="ts" setup>
import { useStore } from 'vuex'
import { getRoutes } from '../lib'
import { computed, ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { CaretLeft, CaretRight, Setting, UserFilled } from '@element-plus/icons-vue'
import type { IMe } from '@/entities'

const store = useStore()
const router = useRouter()
const currentRoute = useRoute()

const me = computed<IMe>(() => store.getters['me/getMe'])
const routes = getRoutes(me.value.myRole)
const isCollapse = ref(true)

const navigateTo = (pathName: string) => {
    router.push({ name: pathName })
}
</script>

<style lang="scss" scoped>
.navigation-bar:not(.el-menu--collapse) {
    width: 200px;
}

.navigation-bar {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    border-right: none;
    border-radius: 0 4px 4px 0;
}
</style>
