<script setup>
import { useI18n } from 'vue-i18n';
import ItemsList from '@/Components/Items/List.vue';
import Badge from '@/Components/Badge.vue';
import { computed } from 'vue';

const { t } = useI18n({});

defineProps({
    issues: {
        type: Object,
        required: true,
    },
});

const searchByOpts = computed(() => [
    { name: t('issues.message'), key: 'message' },
    { name: t('issues.env'), key: 'env' },
    { name: t('issues.http'), key: 'http_code' }
]);
</script>

<template>
    <ItemsList
        :data="issues"
        v-slot="item"
        :searchByOpts="searchByOpts"
        detailsPath="dashboard.issues.details"
    >
        <div class="text-sm md:text-base flex flex-row items-center gap-2">
            <Badge :title="item.env" />
            <Badge :title="`${item.http_code}`" />
            <span>{{ item.message }}</span>
        </div>
    </ItemsList>
</template>
