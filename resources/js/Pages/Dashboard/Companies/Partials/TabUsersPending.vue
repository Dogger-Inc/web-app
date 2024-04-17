<script setup>
import ItemsList from '@/Components/Items/List.vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    users: {
        type: Object,
        required: true,
    },
    companyId: {
        type: Number,
        required: true
    }
});

const acceptUser = (id) => {
    router.patch(
        route('dashboard.companies.accept.patch', {company: props.companyId, userId: id}), 
        {},
        {preserveState: false}
    );
}

const rejectUser = (id) => {
    router.delete(
        route('dashboard.companies.reject.delete', {company: props.companyId, userId: id}), 
        {},
        {preserveState: false}
    );
}

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
            <button @click="acceptUser(item.id)"class="btn success sm">Accept</button>
            <button @click="rejectUser(item.id)" class="btn warning sm">Reject</button>
        </div>
    </ItemsList>
</template>