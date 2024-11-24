<template>
    <el-button style="margin-right: 12px;" type="default" @click="isOpen = true">
        Импортировать
        <el-icon class="el-icon--right"><Upload /></el-icon>
    </el-button>
    <el-drawer v-model="isOpen" :direction="direction">
        <template #header>
            <h4>Импорт сотрудников</h4>
        </template>
        <template #default>
            <div class="sidebar-content">
                <el-select :disabled="isLoading" v-model="selectedOffice" placeholder="Выберите офис">
                    <el-option
                        v-for="office in offices"
                        :key="office.officeId"
                        :label="office.officeName"
                        :value="office.officeId"
                    />
                </el-select>
                <div class="upload-section">
                    <input type="file" id="fileInput" @change="handleFileChange" required />
                    <p v-if="fileError" class="error">{{ fileError }}</p>
                </div>
            </div>
        </template>
        <template #footer>
            <div style="flex: auto">
                <el-button :disabled="isLoading" @click="isOpen = false">Закрыть</el-button>
                <el-button :loading="isLoading" :disabled="isLoading" type="primary" @click="uploadFile">Добавить</el-button>
            </div>
        </template>
    </el-drawer>
</template>

<script lang="ts" setup>
import { type IOffice, uploadEmployees } from '@/entities';
import { Upload } from '@element-plus/icons-vue';
import { ElMessage } from 'element-plus'; // Импортируем ElMessage
import type { DrawerProps } from 'element-plus';
import { computed, onMounted, ref } from 'vue';
import { useStore } from 'vuex';

const isOpen = ref<boolean>(false);
const direction = ref<DrawerProps['direction']>('rtl');
const selectedOffice = ref<number | null>(null);
const fileList = ref<File[]>([]);
const fileError = ref<string | null>(null);
const isLoading = ref<boolean>(false); // Состояние загрузки

const store = useStore();
const offices = computed<IOffice[]>(() => store.getters['office/getOffices']);

onMounted(async () => {
    if (offices.value.length === 0) {
        await store.dispatch('office/getOffices');
    }
});

const handleFileChange = (event: Event) => {
    const input = event.target as HTMLInputElement;
    const file = input.files ? input.files[0] : null;

    if (file) {
        const isXlsx = file.type === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' || file.type === 'application/vnd.ms-excel';

        if (!isXlsx) {
            fileError.value = 'Вы можете загружать только файлы формата xlsx!';
            fileList.value = [];
        } else {
            fileError.value = null;
            fileList.value = [file]; // Сохраняем загруженный файл
        }
    }
};

const uploadFile = async () => {
    if (!selectedOffice.value || fileList.value.length === 0) {
        ElMessage.error('Пожалуйста, выберите офис и файл для загрузки.'); // Используем ElMessage
        return;
    }

    const formData = new FormData();
    formData.append('file', fileList.value[0]); // Добавляем файл в FormData

    isLoading.value = true; // Устанавливаем состояние загрузки

    try {
        const res = await uploadEmployees(selectedOffice.value, formData);
        
        if (res.status === 200) {
            ElMessage.success('Файл успешно загружен!'); // Используем ElMessage
            isOpen.value = false; // Закрываем окошко после успешной загрузки
        } else {
            ElMessage.error('Ошибка при загрузке файла.'); // Используем ElMessage
        }
    } catch (error: any) {
        console.error('Ошибка:', error);
        ElMessage.error('Ошибка при загрузке файла: ' + (error.message || 'Неизвестная ошибка.')); // Используем ElMessage
    } finally {
        isLoading.value = false; // Сбрасываем состояние загрузки
    }
};
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