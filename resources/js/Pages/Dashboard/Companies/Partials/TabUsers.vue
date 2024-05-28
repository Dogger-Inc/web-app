<script setup>
import { router } from '@inertiajs/vue3';
import ItemsList from '@/Components/Items/List.vue';

const props = defineProps({
    users: {
        type: Object,
        required: true,
    },
    companyId: {
        type: Number,
        required: true
    },
});

const revokeUser = (id) => {
    router.patch(
        route('dashboard.companies.reject.patch', { company: props.companyId, userId: id }),
        { preserveState: false }
    );
}
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
        <div class="h-full ml-auto flex gap-4">
            <button @click="revokeUser(item.id)" class="btn warning sm">Revoke</button>
        </div>
    </ItemsList>
</template>

<style lang="scss" scoped></style>