<script setup>
import DashboardLayout from '@/Layouts/Dashboard.vue';
import LinedTitle from '@/Components/LinedTitle.vue';
import ItemsList from '@/Components/Items/List.vue';
import Badge from '@/Components/Badge.vue';
import { useI18n } from 'vue-i18n';

const { t } = useI18n({});

const props = defineProps({
    performanceGroups: {
        type: Object,
        required: true,
    },
});

</script>

<template>
    <DashboardLayout>
        <LinedTitle :title="t('performances.performances')"></LinedTitle>

        <ItemsList
            :data="performanceGroups"
            v-slot="item"
            :searchByOpts="[{ name: t('performances.comments'), key: 'comment' }]"
            detailsPath="dashboard.performances.details"
            detailsValue="key"
            class="w-full mt-8"
        >
            <div class="text-sm md:text-base flex flex-row items-center gap-2">
                <Badge v-if="item.env" :title="item.env" />
                <span>{{ item.key }}</span>
            </div>
        </ItemsList>
    </DashboardLayout>
</template>
