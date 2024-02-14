<script setup>
import { useI18n } from 'vue-i18n';
import { useToast } from 'vue-toastification';
import DataCell from '@/Components/Items/DataCell.vue';

const { t } = useI18n({});
const toast = useToast();

defineProps({
    company: {
        type: Object,
        required: true,
    },
});

const copyToClipboard = (text) => {
    navigator.clipboard.writeText(text);
    toast.success(t("copied"));
};
</script>

<template>
    <dl class="grid grid-cols-1 sm:grid-cols-2">
        <DataCell :title="$t('companies.name')" :value="company.name" :spacer="false" />
        <DataCell
            :title="$t('companies.join')"
            :value="company.key"
            @click.prevent="copyToClipboard(company.key)"
            class="sm:border-t-0"
        />
    </dl>
</template>