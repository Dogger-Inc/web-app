<script setup>
import DashboardLayout from '@/Layouts/Dashboard.vue';
import { useI18n } from "vue-i18n"; 
const { t } = useI18n({});
</script>

<template>
    <DashboardLayout>
        <h1>{{ $t('dashboard.title') }}</h1>
    </DashboardLayout>
</template>

<style lang="scss" scoped>

</style>