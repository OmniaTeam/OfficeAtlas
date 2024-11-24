<template>
    <el-button @click="isOpen = true" type="primary"> Добавить оффис </el-button>
    <el-drawer v-model="isOpen" :direction="direction">
        <template #header>
            <h4>Создание офиса</h4>
            </template>
        <template #default>
            <div class="sidebar-content">
                <div class="sidebar-content__field">
                    <p>Название офиса</p>
                    <el-input v-model="officeName"/>
                </div>
                <div class="sidebar-content__field">
                    <p>Адрес</p>
                    <el-input v-model="officeAddress"/>
                </div>
                <div class="sidebar-content__field">
                    <p>Количество сотрудников</p>
                    <el-input v-model="officeEmployeesnum"/>
                </div>
                <div class="sidebar-content__field">
                    <p>Количество этажей</p>
                    <el-input v-model="officeLevels"/>
                </div>
            </div>
        </template>
        <template #footer>
            <div style="flex: auto">
                <el-button @click="isOpen = false">Закрыть</el-button>
                <el-button :loading="isLoading" type="primary" @click="handleCreate">Добавить</el-button>
            </div>
        </template>
    </el-drawer>
</template>

<script lang="ts" setup>
import { createOffice } from '@/entities/office/api';
import type { DrawerProps } from 'element-plus';
import { ref } from 'vue';
import { useStore } from 'vuex';

const store = useStore()

const isOpen = ref<boolean>(false)
const direction = ref<DrawerProps['direction']>('rtl')

const officeName = ref<string | null>(null)
const officeAddress = ref<string | null>(null)
const officeEmployeesnum = ref<number | null>(null)
const officeLevels = ref<number | null>(null)

const isLoading = ref<boolean>(false)

const handleCreate = async () => {
    isLoading.value = true
    try {
        await createOffice({
            name: officeName.value as string,
            address: officeAddress.value as string,
            numberOfJobs: Number(officeEmployeesnum.value),
            numberLevel: Number(officeLevels.value)
        }).then(async () => {
            isLoading.value = false
            await store.dispatch('office/getOffices')
        })
    } catch (error) {
        console.log(error)
        isLoading.value = false
    }
}
</script>

<style lang="scss" scoped>
.sidebar-content {
    display: flex;
    flex-direction: column;
    gap: 16px;
    width: 100%;
    &__field {
        display: flex;
        flex-direction: column;
        gap: 4px;
        p {
            font-size: 12px;
            color: #909399;
        }
    }
}
</style>
