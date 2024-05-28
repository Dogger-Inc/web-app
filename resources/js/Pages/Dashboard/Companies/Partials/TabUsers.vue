<script setup>
import { useI18n } from 'vue-i18n';
import { router } from '@inertiajs/vue3';
import ItemsList from '@/Components/Items/List.vue';

const { t } = useI18n();

const props = defineProps({
    users: {
        type: Object,
        required: true,
    },
    company: {
        type: Object,
        required: true
    },
});

const revokeUser = (id) => {
    router.patch(
        route('dashboard.companies.reject.patch', { company: props.company.id, userId: id }),
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
        <div v-if="company.editable" class="h-full ml-auto flex gap-4">
            <button @click="revokeUser(item.id)" class="btn warning sm">{{t('companies.revoke')}}</button>
        </div>
    </ItemsList>
</template>

<style lang="scss" scoped></style>