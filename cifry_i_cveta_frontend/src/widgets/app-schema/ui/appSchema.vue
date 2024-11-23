<template>
    <div class="app-schema">
        <div class="app-schema__header">
            <div class="as-header__levels">
                <p>Этажи</p>
                <el-radio-group v-model="isCollapse" style="margin-bottom: 20px">
                    <el-radio-button :value="true">1</el-radio-button>
                    <el-radio-button :value="false">2</el-radio-button>
                </el-radio-group>
            </div>
            <div class="as-header__levels">
                <p>Режимы</p>
                <el-radio-group v-model="modes" style="margin-bottom: 20px">
                    <el-radio-button :value="'workspaces'">Рабочие места</el-radio-button>
                    <el-radio-button :value="'cabinet'">Кабинеты</el-radio-button>
                    <el-radio-button :value="'department'">Отделы</el-radio-button>
                </el-radio-group>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { ref } from 'vue'

const isCollapse = ref<boolean>(true)
const modes = ref<'workspaces' | 'cabinet' | 'department'>('workspaces')
</script>

<style lang="scss" scoped>
.app-schema {
    width: calc(100% - 32px);
    padding: 16px;
    border-radius: 4px;
    border: 2px solid #dcdfe6;
    position: relative;
    overflow: hidden;
    height: calc(100dvh - 500px);
    &__header {
        display: flex;
        gap: 24px;
    }
}

.as-header {
    &__levels {
        display: flex;
        flex-direction: column;
        gap: 4px;
        p {
            font-size: 16px;
            font-weight: 500;
        }
    }
}
</style>
