<script setup>
import DashboardLayout from '@/Layouts/Dashboard.vue';
import LinedTitle from '@/Components/LinedTitle.vue';
import List from '@/Components/Items/List.vue';
import ModalLayout from '@/Layouts/Modal.vue';
import InputWrapper from '@/Components/Form/InputWrapper.vue';
import SelectWrapper from '@/Components/Form/SelectWrapper.vue';
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

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
});

const modalState = ref(false);
const selectedItem = ref(null);
const searchByOpts = [{ name: 'Name', key: 'name' }];

const submit = () => {
    console.log(form)
    form.post(route('dashboard.projects.create.post'), {
        onStart() {
            form.clearErrors();
        },
        onSuccess() {
            modalState.value = false;
            form.reset();
        },
    });
};

</script>

<template>
    <DashboardLayout>
        <LinedTitle title="Projects">
            <button @click.prevent="modalState = true" class="btn primary sm">Create project</button>
        </LinedTitle>

        <List
            :data="projects"
            :selectedItem="selectedItem"
            :searchByOpts="searchByOpts"
            class="w-full mt-8"
            @selected-item="(value) => console.log(value)"
            v-slot="{ item }"
        >
            <div class="flex flex-col">
                <span class="font-bold">{{ item.name }}</span>
                <span class="text-sm text-gray-500">{{ item.key }}</span>
            </div>
        </List>

        <ModalLayout :state="modalState" @close="modalState = false" additionalClasses="card max-w-3xl w-full">
            <LinedTitle title="Create project" />
            <form @submit.prevent="submit" class="flex flex-col gap-5 lg:gap-6 mt-12">
                <InputWrapper
                    v-model="form.name"
                    :error="form.errors.name"
                    :required="true"
                    title="Name"
                />
                <SelectWrapper
                    v-model="form.company_id"
                    :error="form.errors.name"
                    :required="true"
                    :options="companies"
                    reduce="id"
                    title="Company"
                />
                <button class="btn primary sm float-right" type="submit">Submit</button>
            </form>
        </ModalLayout>
    </DashboardLayout>
</template>
