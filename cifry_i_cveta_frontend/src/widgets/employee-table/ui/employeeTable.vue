<template>
    <div class="employee-table">
        <el-table v-loading="isLoading" :data="employees.employees" style="width: 100%;">
            <el-table-column prop="employeeFio" label="ФИО" show-overflow-tooltip />
            <el-table-column prop="employeeSpec" label="Специальность" show-overflow-tooltip />
            <el-table-column prop="employeeDepartment" label="Отдел" show-overflow-tooltip />
            <el-table-column prop="employeePhone" label="Телефон" show-overflow-tooltip />
            <el-table-column prop="employeeEmail" label="Email" show-overflow-tooltip />
        </el-table>
    </div>
    <div class="pagination-container">
        <el-pagination
            :page-size="10"
            :total="employees.pagination.total"
            :current-page="employees.pagination.currentPage"
            layout="prev, pager, next"
            @current-change="changePage"
        />
    </div>
</template>

<script lang="ts" setup>
import { computed } from 'vue';
import type { IEmployee } from '@/entities';
import { useStore } from 'vuex';

const store = useStore()

const isLoading = computed(() => store.state.employee.fetchEmployees === 'PENDING')

const employees = computed<{
    pagination: {
        perPage: number,
        currentPage: number,
        total: number
    },
    employees: IEmployee[]
}>(() => store.getters['employee/getEmployees'])

const changePage = (page: number) => {
    store.dispatch('employee/updatePagination', {
        perPage: 10,
        currentPage: page
    }).then(async () => {
        await store.dispatch('employee/getEmployees', {
            pagination: {
                perPage: employees.value.pagination.perPage,
                currentPage: employees.value.pagination.currentPage
            }
        })
    })
}
</script>

<style scoped>
.employee-table {
    border: 1px solid #E4E7ED;
}
.el-table th {
    text-align: center;
    background-color: #f5f7fa;
    font-weight: 600;
}
.pagination-container {
    display: flex;
    justify-content: flex-end;
    margin-top: 16px;
}
.employee-fio {
    color: #337ecc;
    text-decoration: none;
    cursor: pointer;
}
.sidebar {
    position: fixed;
    top: 0;
    right: 0;
    width: 33.33%;
    height: 100%;
    background-color: #fff;
    box-shadow: -2px 0 5px rgba(0, 0, 0, 0.1);
    padding: 20px;
    overflow-y: auto;
    z-index: 1000;
}
.sidebar-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #e4e7ed;
    padding-bottom: 10px;
    margin-bottom: 20px;
}
.sidebar-content {
    margin: 0;
}
.close-button {
    background: none;
    border: none;
    font-size: 30px;
    color: #606266;
    cursor: pointer;
}
.sidebar-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 999;
}
.employee-info {
    display: flex;
    align-items: flex-start;
    margin-bottom: 20px;
}
.employee-avatar {
    width: 180px;
    height: 180px;
    background-color: #e4e7ed;
    margin-right: 20px;
}
.employee-details p {
    margin: 5px 0;
}
.employee-details strong {
    display: block;
    color: #999;
    font-weight: normal;
}
.equipment-section {
    margin-top: 25px;
}
.equipment-item {
    margin-top: 15px;
    margin-bottom: 20px;
    border: 1px solid #e4e7ed;
    padding: 10px;
    border-radius: 4px;
}
.equipment-item p {
    margin: 5px 0;
    color: #909399;
}
.equipment-item strong {
    display: block;
    color: black;
    font-weight: normal;
}
.equipment-quality {
    display: inline-block;
    padding: 2px 5px;
    border: 1px solid #D9ECFF;
    background-color: #ECF5FF;
    border-radius: 4px;
    color: #3a85ff;
}
.show-more-button {
    background: none;
    border: none;
    color: #337ecc;
    cursor: pointer;
    text-align: left;
    padding: 0;
    margin-top: 10px;
}
</style>
