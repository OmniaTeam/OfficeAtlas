<template>
    <el-button @click="isOpen = true" type="primary"> Добавить сотрудника </el-button>
    <el-drawer v-model="isOpen" :direction="direction">
        <template #header>
            <h4>Добавление сотрудника</h4>
            </template>
        <template #default>
            <div class="sidebar-content">
                <div class="sidebar-content__field">
                    <p>Выберите оффис</p>
                    <el-select :disabled="isLoading" v-model="selectedOffice" placeholder="Выберите офис">
                        <el-option
                            v-for="office in offices"
                            :key="office.officeId"
                            :label="office.officeName"
                            :value="office.officeId"
                        />
                    </el-select>
                </div>
                <div class="sidebar-content__field">
                    <p>ФИО сотрудника</p>
                    <el-input :disabled="isLoading" v-model="employeeFio"/>
                </div>
                <div class="sidebar-content__field">
                    <p>Cпециальность</p>
                    <el-select :disabled="isLoading" v-model="employeeSpec" placeholder="Выберите специальность">
                        <el-option
                            v-for="(spec, index) in specs()"
                            :key="index"
                            :label="spec.label"
                            :value="spec.value"
                        />
                    </el-select>
                </div>
                <div class="sidebar-content__field">
                    <p>Отдел</p>
                    <el-select :disabled="isLoading" v-model="employeeDepartment" placeholder="Выберите отдел">
                        <el-option
                            v-for="(deps, index) in departments()"
                            :key="index"
                            :label="deps.label"
                            :value="deps.value"
                        />
                    </el-select>
                </div>
                <div class="sidebar-content__field">
                    <p>Роль</p>
                    <el-select :disabled="isLoading" v-model="employeeRole" placeholder="Выберите роль">
                        <el-option
                            v-for="(role, index) in roles()"
                            :key="index"
                            :label="role.label"
                            :value="role.value"
                        />
                    </el-select>
                </div>
                <div class="sidebar-content__field">
                    <p>Email</p>
                    <el-input :disabled="isLoading" v-model="employeeEmail"/>
                </div>
                <div class="sidebar-content__field">
                    <p>Ссылка на страницу</p>
                    <el-input :disabled="isLoading" v-model="employeeLink"/>
                </div>
                <div class="sidebar-content__field">
                    <p>Номер телефона</p>
                    <el-input :disabled="isLoading" v-model="employeePhone"/>
                </div>
            </div>
        </template>
        <template #footer>
            <div style="flex: auto">
                <el-button :disabled="isLoading" @click="isOpen = false">Закрыть</el-button>
                <el-button :disabled="isLoading" :loading="isLoading" type="primary" @click="createHandler">Добавить</el-button>
            </div>
        </template>
    </el-drawer>
</template>

<script lang="ts" setup>
import { createEmployee, EDepartments, ERoles, ESpecs, type IOffice } from '@/entities';
import { ElMessage, type DrawerProps } from 'element-plus';
import { computed, onMounted, ref } from 'vue';
import { useStore } from 'vuex';

const store = useStore();
const offices = computed<IOffice[]>(() => store.getters['office/getOffices']);

const isOpen = ref<boolean>(false)
const direction = ref<DrawerProps['direction']>('rtl')

const selectedOffice = ref<number | null>(null);
const employeeFio = ref<string | null>(null)
const employeeSpec = ref<ESpecs | null>(null)
const employeeEmail = ref<string | null>(null)
const employeeLink = ref<string | null>(null)
const employeePhone = ref<string | null>(null)
const employeeDepartment = ref<EDepartments | null>(null)
const employeeRole = ref<ERoles | null>(null)

const isLoading = ref<boolean>(false)

const createHandler = async () => {
    isLoading.value = true
    await createEmployee(Number(selectedOffice.value), String(employeeFio), String(employeeSpec), String(employeeEmail), String(employeeLink), String(employeePhone), String(employeeDepartment), String(employeeRole)).then((res) => {
        if (res?.status === 200 || res?.status === 201) {
            ElMessage.success('Сотрудник успешно создан!')
            isLoading.value = false
            isOpen.value = false
            store.dispatch('employee/getEmployees', {
                pagination: {
                    perPage: 10,
                    currentPage: 1
                }
            })
        } else {
            ElMessage.success('Что-то пошло не так :(')
        }
    })
}

onMounted(async () => {
    if (offices.value.length === 0) {
        await store.dispatch('office/getOffices');
    }
});


const roles = () => {
    return [
        {
            value: ERoles.MANAGER,
            label: "Офис-менеджер"
        },
        {
            value: ERoles.SYSADMIN,
            label: "Системный администратор"
        },
        {
            value: ERoles.STAFF,
            label: "Сотрудник"
        },
    ]
}

const specs = () => {
    return [
        {
            value: ESpecs.SOFTWARE_ENGINEER,
            label: "Программист"
        },
        {
            value: ESpecs.FRONTEND_DEVELOPER,
            label: "Фронтенд-разработчик"
        },
        {
            value: ESpecs.BACKEND_DEVELOPER,
            label: "Бэкенд-разработчик"
        },
        {
            value: ESpecs.FULL_STACK_DEVELOPER,
            label: "Фулл-стек разработчик"
        },
        {
            value: ESpecs.DEVOPS_ENGINEER,
            label: "DevOps-инженер"
        },
        {
            value: ESpecs.QA_ENGINEER,
            label: "Тестировщик"
        },
        {
            value: ESpecs.PRODUCT_MANAGER,
            label: "Продакт-менеджер"
        },
        {
            value: ESpecs.UX_UI_DESIGNER,
            label: "UX/UI-дизайнер"
        },
        {
            value: ESpecs.SYSTEM_ADMINISTRATOR,
            label: "Системный администратор"
        },
        {
            value: ESpecs.DATA_SCIENTIST,
            label: "Дата-сайентист"
        },
        {
            value: ESpecs.DATABASE_ADMINISTRATOR,
            label: "Администратор баз данных"
        },
        {
            value: ESpecs.NETWORK_ENGINEER,
            label: "Сетевой инженер"
        },
        {
            value: ESpecs.SECURITY_ANALYST,
            label: "Аналитик по безопасности"
        },
        {
            value: ESpecs.TECHNICAL_SUPPORT,
            label: "Техническая поддержка"
        },
        {
            value: ESpecs.PROJECT_MANAGER,
            label: "Менеджер проекта"
        },
        {
            value: ESpecs.BUSINESS_ANALYST,
            label: "Бизнес-аналитик"
        },
    ]
}

const departments = () => {
    return [
        {
            value: EDepartments.DEVELOPMENT,
            label: "Разработка"
        },
        {
            value: EDepartments.QA,
            label: "Контроль качества"
        },
        {
            value: EDepartments.DESIGN,
            label: "Дизайн"
        },
        {
            value: EDepartments.PRODUCT,
            label: "Продукт"
        },
        {
            value: EDepartments.IT_SUPPORT,
            label: "Техническая поддержка"
        },
        {
            value: EDepartments.HR,
            label: "Кадровый отдел"
        },
        {
            value: EDepartments.SALES,
            label: "Отдел продаж"
        },
        {
            value: EDepartments.MARKETING,
            label: "Маркетинг"
        },
        {
            value: EDepartments.DATA_ANALYSIS,
            label: "Анализ данных"
        },
    ]
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
