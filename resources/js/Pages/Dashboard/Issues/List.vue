<script setup>
import DashboardLayout from '@/Layouts/Dashboard.vue';
import LinedTitle from '@/Components/LinedTitle.vue';
import ItemsList from '@/Components/Items/List.vue';
import Badge from '@/Components/Badge.vue';
import { ref } from 'vue';

const props = defineProps({
    issues: {
        type: Object,
        required: true,
    },
});

const selectedItem = ref(null);
const searchByOpts = [{ name: 'Message', key: 'message' }];

</script>

<template>
    <DashboardLayout>
        <LinedTitle title="Issues"></LinedTitle>

        <ItemsList
            :data="issues"
            v-slot="item"
            :selectedItem="selectedItem"
            :searchByOpts="searchByOpts"
            detailsPath="dashboard.issues.details"
            class="w-full mt-8"
            @selected-item="(value) => console.log(value)"
        >
            <div class="text-sm md:text-base flex flex-row items-center gap-2">
                <Badge :title="item.env" />
                <Badge :title="`${item.http_code}`" />
                <span>{{ item.message }}</span>
            </div>
        </ItemsList>
    </DashboardLayout>
</template>
