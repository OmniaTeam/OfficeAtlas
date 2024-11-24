<script setup lang="ts">
import { Routing } from '@/pages'
import { ApplicationLayout, AuthProvider } from './layouts'
</script>

<template>
    <AuthProvider>
        <ApplicationLayout>
            <Routing />
        </ApplicationLayout>
    </AuthProvider>
</template>

<style lang="scss">
@import './index.scss';
</style>
