<script setup>
import ItemsList from '@/Components/Items/List.vue';

defineProps({
    users: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <ItemsList
        :data="users"
        :searchbar="false"
        v-slot="item"
    >
        <div>
            <p class="text-sm md:text-base font-semibold">{{ item.fullname }}</p> 
            <p class="text-xs md:text-sm font-medium text-gray-500">
                {{ item.email }}
            </p>
        </div>
    </ItemsList>
</template>