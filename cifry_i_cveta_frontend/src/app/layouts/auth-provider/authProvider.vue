<template>
    <template v-if="isLoading">
        <el-loading :text="'Загрузка...'">
            <slot v-if="!isLoading" />
        </el-loading>
    </template>
    <template v-else><slot /></template>
</template>

<script lang="ts" setup>
import { computed, onMounted } from 'vue';
import { useStore } from 'vuex';
import { ElLoading } from 'element-plus';

const store = useStore();

const isLoading = computed(() => 
    store.state.me.fetchMeState === 'PENDING'
);

const me = computed(() => store.getters['me/getMe']);

onMounted(async () => {
    const loadingInstance = ElLoading.service({
        spinner: 'el-icon-loading',
        background: 'rgba(255, 255, 255, 0.7)',
    });

    try {
        await store.dispatch('me/getMe');
        if (me.value.myRole && (window.location.href === 'https://theomnia.ru/' || window.location.href === 'https://theomnia.ru/auth')) {
            window.location.href = 'https://theomnia.ru/employee';
        } else if (!me.value.myRole && window.location.href !== 'https://theomnia.ru/' && window.location.href !== 'https://theomnia.ru/auth') {
            window.location.href = 'https://theomnia.ru/';
        }
    } finally {
        loadingInstance.close();
    }
});
</script>

<style lang="scss" scoped></style>