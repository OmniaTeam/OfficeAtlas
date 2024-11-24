<template>
    <div class="offices">
        <OfficeCard
            v-for="(office, index) in offices"
            :key="index"
            :office-name="office.officeName"
            :office-address="office.officeAdress"
            :office-employeenum="office.officeEmployeenum"
            :office-levelsnum="office.officeLevelsnum"
        />
    </div>
</template>

<script lang="ts" setup>
import type { IOffice } from '@/entities';
import { OfficeCard } from '@/shared';
import { computed } from 'vue';
import { useStore } from 'vuex';

const store = useStore();
const offices = computed<IOffice[]>(() => store.getters['office/getOffices']);
</script>

<style lang="scss" scoped>
.offices {
    display: flex;
    gap: 24px;
    flex-wrap: wrap;
    margin-top: 24px;
}
</style>