<template>
    <div class="office-card">
        <div class="office-card__header">
            <p>{{ officeName }}</p>
        </div>
        <div style="width: 100%; background-color: #DCDFE6; height: 2px;" />
        <div class="office-card__footer">
            <div class="office-card-info">
                <p class="office-card-info__title">Адрес</p>
                <p class="office-card-info__value">{{ officeAddress }}</p>
            </div>
            <div class="office-card-info">
                <p class="office-card-info__title">Количество сотрудников</p>
                <p class="office-card-info__value">{{ officeEmployeenum }}</p>
            </div>
            <div class="office-card-info">
                <p class="office-card-info__title">Количество этажей</p>
                <p class="office-card-info__value">{{ officeLevelsnum }}</p>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import type { PropType } from 'vue';

defineProps({
    officeName: {
        type: String as PropType<string | null>,
        required: true
    },
    officeAddress: {
        type: String as PropType<string | null>,
        required: true
    },
    officeEmployeenum: {
        type: Number as PropType<number | null>,
        required: true
    },
    officeLevelsnum: {
        type: Number as PropType<number | null>,
        required: true
    }
})
</script>

<style lang="scss" scoped>
.office-card {
    border: 2px solid #DCDFE6;
    border-radius: 4px;
    background-color: #FFF;
    display: flex;
    flex-direction: column;
    gap: 16px;
    padding: 16px;
    width: 289px;
    &__header {
        display: flex;
        flex-direction: column;
        gap: 4px;
        p {
            font-size: 18px;
            font-weight: 500;
        }
    }
    &__footer {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    &-info {
        display: flex;
        flex-direction: column;
        gap: 4px;
        &__title {
            font-size: 12px;
            color: #909399;
        }
        &__value {
            font-size: 14px;
            font-weight: 500;
        }
    }
}
</style>