<script setup>
import ItemsList from '@/Components/Items/List.vue';
import Badge from '@/Components/Badge.vue';

defineProps({
    issues: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <ItemsList
        :data="issues"
        :searchbar="false"
        v-slot="item"
        detailsPath="dashboard.issues.details"
    >
        <div class="text-sm md:text-base flex flex-row items-center gap-2">
            <Badge :title="item.env" />
            <Badge :title="`${item.http_code}`" />
            <span>{{ item.message }}</span>
        </div>
    </ItemsList>
</template>
