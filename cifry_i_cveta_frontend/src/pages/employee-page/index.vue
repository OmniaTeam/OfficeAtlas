<template>
    <div>
        <AppHeader :role="me.myRole" />
        <div class="table-container">
            <EmployeeTable />
        </div>
    </div>
</template>

<script lang="ts" setup>
import type { IEmployee, IMe } from '@/entities'
import { AppHeader, EmployeeTable } from '@/widgets'
import { computed, onMounted } from 'vue'
import { useStore } from 'vuex'

const store = useStore()

const me = computed<IMe>(() => store.getters['me/getMe'])
const employees = computed<{
    pagination: {
        perPage: number,
        currentPage: number,
        totalCount: number
    },
    employees: IEmployee[]
}>(() => store.getters['employee/getEmployees'])

onMounted(async () => {
    await store.dispatch('employee/getEmployees', {
        pagination: {
            perPage: employees.value.pagination.perPage,
            currentPage: employees.value.pagination.currentPage
        }
    })
})
</script>

<style lang="scss" scoped>
.header-title {
    font-size: 18px;
    font-weight: 500;
    line-height: 26px;
}

.filter-container {
    margin-bottom: 20px;
}

.table-container {
    margin-top: 20px;
}
</style>
