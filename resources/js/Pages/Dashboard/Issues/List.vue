<script setup>
import DashboardLayout from '@/Layouts/Dashboard.vue';
import LinedTitle from '@/Components/LinedTitle.vue';
import ItemsList from '@/Components/Items/List.vue';
import Badge from '@/Components/Badge.vue';
import { useI18n } from 'vue-i18n';

const { t } = useI18n({});

const props = defineProps({
    issues: {
        type: Object,
        required: true,
    },
});

</script>

<template>
    <DashboardLayout>
        <LinedTitle :title="t('issues.issues')"></LinedTitle>

        <ItemsList
            :data="issues"
            v-slot="item"
            :searchByOpts="[{ name: t('issues.message'), key: 'message' }]"
            detailsPath="dashboard.issues.details"
            class="w-full mt-8"
        >
            <div class="text-sm md:text-base flex flex-row items-center gap-2">
                <Badge v-if="item.env" :title="item.env" />
                <Badge v-if="item.http_code" :title="`${item.http_code}`" />
                <span>{{ item.message }}</span>
            </div>
        </ItemsList>
    </DashboardLayout>
</template>
