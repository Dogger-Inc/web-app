<script setup>
import ItemsList from '@/Components/Items/List.vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    users: {
        type: Object,
        required: true,
    },
    company: {
        type: Object,
        required: true,
    },
});

const revokeUser = (id) => {
    if(props.company) {
        router
        .delete(route('dashboard.companies.reject.delete', { company: props.company.id, userId: id }),
            {},
            { preserveState: false }
        )
    }
}

</script>

<template>
    <ItemsList :data="users" :searchbar="false" v-slot="item">
        <div>
            <p class="text-sm md:text-base font-semibold">{{ item.fullname }}</p>
            <p class="text-xs md:text-sm font-medium text-gray-500">
                {{ item.email }}
            </p>
        </div>
        <div v-if="props.company">
            <div class="h-full ml-auto flex gap-4">
                <button @click="revokeUser(item.id)" class="btn warning sm">Revoke</button>
            </div>
        </div>
    </ItemsList>
</template>