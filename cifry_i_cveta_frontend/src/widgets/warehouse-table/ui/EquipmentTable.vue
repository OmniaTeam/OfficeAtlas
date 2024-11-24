<template>
    <div class="equipment-table">
        <el-table
            :data="paginatedEquipment"
            style="width: 100%;"
            @selection-change="handleSelectionChange"
        >
            <el-table-column type="selection" width="50" />

            <el-table-column prop="equipmentId" label="ID" width="50" />
            
            <el-table-column prop="equipmentName" label="Название оборудования" show-overflow-tooltip>
                <template #default="scope">
                    <a
                        :href="scope.row.equipmentLink"
                        class="equipment-name"
                        target="_blank"
                        rel="noopener noreferrer"
                    >
                        {{ scope.row.equipmentName }}
                    </a>
                </template>
            </el-table-column>
            <el-table-column prop="equipmentModel" label="Модель" show-overflow-tooltip />
            <el-table-column prop="equipmentSerialnum" label="Серийный номер" show-overflow-tooltip />
            <el-table-column prop="equipmentQuality" label="Состояние" show-overflow-tooltip />
            <el-table-column prop="equipmentStatus" label="Статус" show-overflow-tooltip />
            <el-table-column prop="equipmentDateby" label="Дата приобретения" show-overflow-tooltip />
        </el-table>
    </div>
    <div class="pagination-container">
        <el-pagination
            layout="prev, pager, next"
            :page-size="10"
            :current-page.sync="currentPage"
            :total="equipment.length"
            @current-change="handlePageChange"
        />
    </div>
</template>

<script lang="ts">
import { defineComponent, onMounted, ref, computed } from 'vue';
import { getEquipment } from '@/widgets/warehouse-table/lib'; 
import type { IEquipment } from '@/entities'; 

export default defineComponent({
    name: 'EquipmentTable',
    setup() {
        const equipment = ref<IEquipment[]>([]);
        const currentPage = ref(1);
        const selectedEquipment = ref<IEquipment[]>([]);

        
        const fetchEquipment = () => {
            equipment.value = getEquipment(); 
        };

        
        const paginatedEquipment = computed(() =>
            equipment.value.slice((currentPage.value - 1) * 10, currentPage.value * 10)
        );

        
        const handlePageChange = (page: number) => {
            currentPage.value = page;
        };

        
        const handleSelectionChange = (selection: IEquipment[]) => {
            selectedEquipment.value = selection;
        };

        onMounted(fetchEquipment);

        return {
            equipment,
            paginatedEquipment,
            currentPage,
            handlePageChange,
            handleSelectionChange,
        };
    },
});
</script>

<style scoped>
.equipment-table {
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
.equipment-name {
    color: #337ecc;
    text-decoration: none;
    cursor: pointer;
}
</style>
