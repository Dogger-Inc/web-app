<script setup>
import { useI18n } from 'vue-i18n';
import { useToast } from 'vue-toastification';
import DataCell from '@/Components/Items/DataCell.vue';
import { router } from '@inertiajs/vue3';

const { t } = useI18n({});
const toast = useToast();

const props = defineProps({
    company: {
        type: Object,
        required: true,
    },
});

const copyToClipboard = (text) => {
    navigator.clipboard.writeText(text);
    toast.success(t("copied"));
};

const handleUpdateCompanyCode = () => {
    router.patch(route('dashboard.companies.refresh_code.patch', { company: props.company?.id }));
}
</script>

<template>
    <dl class="grid grid-cols-1 sm:grid-cols-2">
        <DataCell title="Nom" :value="company.name" :spacer="false" />
        <DataCell
            title="Code d'invitation"
            :value="company.key"
            @click.prevent="copyToClipboard(company.key)"
            class="sm:border-t-0"
        />
        <button
            v-if="company.editable"
            @click.prevent="handleUpdateCompanyCode"
            class="btn generic sm mt-3"
        >
            Change code
        </button>
    </dl>
</template>
