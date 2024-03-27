<script setup>
import ItemsList from '@/Components/Items/List.vue';

const props = defineProps({
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
        <div class="w-full">
            <p class="text-sm md:text-base font-semibold">{{ item.fullname }}</p> 
            <p class="text-xs md:text-sm font-medium text-gray-500">
                {{ item.email }}
            </p>
        </div>
        <div class="h-full ml-auto flex gap-4">
            <button class="btn success sm">Accepter</button>
            <button class="btn warning sm">Refuser</button>
        </div>
    </ItemsList>
</template>