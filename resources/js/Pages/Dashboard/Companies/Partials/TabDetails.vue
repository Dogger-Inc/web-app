<script setup>
import DataCell from '@/Components/Items/DataCell.vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    company: {
        type: Object,
        required: true,
    },
});

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
        <DataCell :title="$t('name')" :value="company.name" :spacer="false" />
        <div class="flex flex-row items-center gap-6">
            <DataCell
                :title="$t('companies.join')"
                :value="company.key"
                copyable
                class="sm:border-t-0"
            />
            <button
                v-if="company.editable"
                @click.prevent="handleUpdateCompanyCode"
                class="btn generic sm"
            >
                {{$t('companies.change_code')}}
            </button>
        </div>
    </div>
</template>
