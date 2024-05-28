<script setup>
import { useI18n } from 'vue-i18n';
import { router, useForm } from '@inertiajs/vue3';
import ItemsList from '@/Components/Items/List.vue';
import MultiSelectWrapper from '@/Components/Form/MultiSelectWrapper.vue';

const { t } = useI18n();

const props = defineProps({
    users: {
        type: Object,
        required: true,
    },
    assignableUsers: {
        type: Array,
        required: true,
    },
    projectId: {
        type: Number,
        required: true,
    }
});

const form = useForm({
    users: [],
});

const submit = () => {
    form.post(route('dashboard.projects.assignUsers.post', props.projectId), {
        preserveState: false,
        onStart: () => form.clearErrors(),
        onSuccess: () => form.reset(),
    });
};

const unassignUser = (id) => {
    router.patch(
        route('dashboard.projects.unassignUser.patch', { project: props.projectId, userId: id }),
        {},
        { preserveState: false }
    );
}
</script>

<template>
    <form @submit.prevent="submit" class="flex flex-col xs:flex-row gap-5 lg:gap-6 mb-6 sm:mb-8">
        <MultiSelectWrapper
            v-model="form.users"
            :error="form.errors.users"
            :options="assignableUsers"
            reduce="id"
            label="fullname"
            :title="t('projects.assigned_user')"
            class="flex-1"
        />
        <button class="btn primary sm" type="submit">{{t('projects.submit')}}</button>
    </form>
    
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
            <button @click="unassignUser(item.id)" class="btn warning sm">Unassign</button>
        </div>
    </ItemsList>
</template>

<style lang="scss" scoped></style>