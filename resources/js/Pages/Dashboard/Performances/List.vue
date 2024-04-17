<script setup>
import DashboardLayout from '@/Layouts/Dashboard.vue';
import LinedTitle from '@/Components/LinedTitle.vue';
import ItemsList from '@/Components/Items/List.vue';
import Badge from '@/Components/Badge.vue';
import dayjs from 'dayjs';
import duration from 'dayjs/plugin/duration';
import relativeTime from 'dayjs/plugin/relativeTime';
import { useI18n } from 'vue-i18n';

dayjs.extend(duration)
dayjs.extend(relativeTime)

const { t } = useI18n({});

const props = defineProps({
    performanceGroups: {
        type: Array,
        required: true,
    },
});

</script>

<template>
    <DashboardLayout>
        <LinedTitle :title="t('performances.issues')"></LinedTitle>

        <ItemsList
            :data="performanceGroups"
            v-slot="item"
            :searchByOpts="[{ name: t('performances.comment'), key: 'comment' }]"
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
