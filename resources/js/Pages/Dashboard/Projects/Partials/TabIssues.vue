<script setup>
import { useI18n } from 'vue-i18n';
import ItemsList from '@/Components/Items/List.vue';
import { computed } from 'vue';

const { t } = useI18n({});

defineProps({
    issues: {
        type: Object,
        required: true,
    },
});

const searchByOpts = computed(() => [{ name: t('issues.message'), key: 'message' }, { name: t('issues.env'), key: 'env' }, { name: t('issues.http'), key: 'http_code' }]);
</script>

<template>
    <ItemsList
        :data="issues"
        v-slot="item"
        :searchByOpts="searchByOpts"
        detailsPath="dashboard.issues.details"
    >
        <div class="text-sm md:text-base">
            <code class="text-[10px] text-dogger-orange-500 bg-dogger-orange-200 border-dogger-orange-500 border rounded p-0.5">{{ item.env }}</code> -
            <span class="font-bold">[{{ item.http_code }}] </span>
            <span>{{ item.message }}</span>
        </div>
    </ItemsList>
</template>
