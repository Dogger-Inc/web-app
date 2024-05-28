<template>
    <ItemsList
        :data="performanceGroups"
        :searchbar="false"
        v-slot="item"
        detailsValue="key"
        detailsPath="dashboard.performances.details"
    >
        <div class="text-sm md:text-base flex flex-row items-center gap-2">
            <Badge v-if="item.env" :title="item.env" />
            <Badge :title="`${days(item.created_at).format('YYYY-MM-DD')}`" />
            <span>{{ item.key }}</span>
        </div>
    </ItemsList>
</template>

<script setup>
import ItemsList from '@/Components/Items/List.vue';
import Badge from '@/Components/Badge.vue';
import days from 'dayjs';

defineProps({
    performanceGroups: {
        type: Object,
        required: true,
    }
})
</script>
