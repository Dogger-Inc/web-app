<script setup>
import ItemsList from '@/Components/Items/List.vue';
import { router } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const props = defineProps({
    users: {
        type: Object,
        required: true,
    },
    company: {
        type: Object,
        required: true
    }
});

const acceptUser = (id) => {
    router.patch(
        route('dashboard.companies.accept.patch', {company: props.company.id, userId: id}),
        {},
        { preserveState: false }
    );
}

const rejectUser = (id) => {
    router.delete(
        route('dashboard.companies.reject.delete', {company: props.company.id, userId: id}),
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
        <div class="w-full">
            <p class="text-sm md:text-base font-semibold">{{ item.fullname }}</p> 
            <p class="text-xs md:text-sm font-medium text-gray-500">
                {{ item.email }}
            </p>
        </div>
        <div v-if="company.editable" class="h-full ml-auto flex gap-4">
            <button @click="acceptUser(item.id)" class="btn success sm">{{ $t('accept') }}</button>
            <button @click="rejectUser(item.id)" class="btn warning sm">{{ $t('reject') }}</button>
        </div>
    </ItemsList>
</template>