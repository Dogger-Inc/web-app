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
    router.patch(
        route('dashboard.companies.refresh_code.patch', props.company?.id),
        {},
        { preserveState: false }
    );
}
</script>

<template>
    <div class="grid grid-cols-1 sm:grid-cols-2">
        <DataCell :title="$t('companies.name')" :value="company.name" :spacer="false" />
        <div class="flex flex-row items-center gap-6">
            <DataCell
                :title="$t('companies.join')"
                :value="company.key"
                @click.prevent="copyToClipboard(company.key)"
                class="sm:border-t-0"
            />
            <button
                v-if="company.editable"
                @click.prevent="handleUpdateCompanyCode"
                class="btn generic sm"
            >
                {{$t('companies.join')}}
            </button>
        </div>
    </div>
</template>
