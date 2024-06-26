<script setup>
import { ref, computed } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import DashboardLayout from '@/Layouts/Dashboard.vue';
import LinedTitle from '@/Components/LinedTitle.vue';
import ItemsList from '@/Components/Items/List.vue';
import ModalLayout from '@/Layouts/Modal.vue';
import InputWrapper from '@/Components/Form/InputWrapper.vue';
import SelectWrapper from '@/Components/Form/SelectWrapper.vue';
import MultiSelectWrapper from '@/Components/Form/MultiSelectWrapper.vue';

const { t } = useI18n();

const props = defineProps({
    projects: {
        type: Object,
        required: true,
    },
    companies: {
        type: Array,
        required: true,
    },
});

const form = useForm({
    name: '',
    company_id: undefined,
    users: [],
});

const companyUsers = computed(() => {
    if (!form.company_id) return [];
    return props.companies.find(company => company.id === form.company_id).users;
});

const modalState = ref(false);

const submit = () => {
    form.post(route('dashboard.projects.create.post'), {
        onStart: () => form.clearErrors(),
        onSuccess() {
            modalState.value = false;
            form.reset();
        },
    });
};
</script>

<template>
    <DashboardLayout>
        <LinedTitle :title="t('projects.projects')">
            <button @click.prevent="modalState = true" class="btn primary sm">{{ t('projects.add') }}</button>
        </LinedTitle>

        <ItemsList
            :data="projects"
            :searchByOpts="[{ name: t('projects.name'), key: 'name' }]"
            detailsPath="dashboard.projects.details"
            class="mt-8"
            v-slot="item"
        >
            <div class="flex flex-col">
                <span class="font-bold">{{ item.name }}</span>
                <span class="text-sm text-gray-500">{{ item.key }}</span>
            </div>
        </ItemsList>

        <ModalLayout :state="modalState" @close="modalState = false" additionalClasses="card max-w-3xl w-full">
            <LinedTitle :title="t('projects.add')" />
            <form @submit.prevent="submit" class="flex flex-col gap-5 lg:gap-6 mt-12">
                <InputWrapper
                    v-model="form.name"
                    :error="form.errors.name"
                    :title="t('name')"
                    required
                />
                <SelectWrapper
                    v-model="form.company_id"
                    :error="form.errors.name"
                    :options="companies"
                    reduce="id"
                    :title="t('companies.title')"
                    required
                />
                <MultiSelectWrapper
                    v-model="form.users"
                    :error="form.errors.users"
                    :options="companyUsers"
                    :disabled="!form.company_id"
                    reduce="id"
                    label="fullname"
                    :title="t('projects.assigned_user')"
                />
                <button class="btn primary sm" type="submit">{{t('projects.submit')}}</button>
            </form>
        </ModalLayout>
    </DashboardLayout>
</template>
