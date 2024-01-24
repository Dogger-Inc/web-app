<script setup>
import DashboardLayout from '@/Layouts/Dashboard.vue';
import LinedTitle from '@/Components/LinedTitle.vue';
import List from '@/Components/Items/List.vue';
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

        <List
            :data="issues"
            :selectedItem="selectedItem"
            :searchByOpts="searchByOpts"
            class="w-full mt-8"
            @selected-item="(value) => console.log(value)"
            v-slot="item"
        >
            <slot name="listItem" :item="item.item" />
        </List>
    </DashboardLayout>
</template>
