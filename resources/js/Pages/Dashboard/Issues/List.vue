<script setup>
import DashboardLayout from '@/Layouts/Dashboard.vue';
import LinedTitle from '@/Components/LinedTitle.vue';
import ItemsList from '@/Components/Items/List.vue';
import Badge from '@/Components/Badge.vue';

const props = defineProps({
    issues: {
        type: Object,
        required: true,
    },
});

</script>

<template>
    <DashboardLayout>
        <LinedTitle title="Issues"></LinedTitle>

        <ItemsList
            :data="issues"
            v-slot="item"
            :searchByOpts="[{ name: 'Message', key: 'message' }]"
            detailsPath="dashboard.issues.details"
            class="w-full mt-8"
        >
            <div class="text-sm md:text-base flex flex-row items-center gap-2">
                <Badge :title="item.env" />
                <Badge :title="`${item.http_code}`" />
                <span>{{ item.message }}</span>
            </div>
        </ItemsList>
    </DashboardLayout>
</template>
