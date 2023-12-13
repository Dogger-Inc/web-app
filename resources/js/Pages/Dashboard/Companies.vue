<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { useToast } from 'vue-toastification';
import ModalLayout from '@/Layouts/Modal.vue';
import ItemsDisplay from '@/Components/Items/Display.vue';
import DashboardLayout from '@/Layouts/Dashboard.vue';
import InputWapper from '@/Components/Form/InputWrapper.vue';
import LinedTitle from '@/Components/LinedTitle.vue';

const toast = useToast();
const props = defineProps({
    companies: {
        type: Object,
        required: true,
    },
});

const modalState = ref(false);

const form = useForm({
    name: '',
});

const copyToClipboard = (text) => {
    navigator.clipboard.writeText(text);
    toast.success('Copied to clipboard');
};

const submit = () => {
    form.post(route('dashboard.companies.create.post'), {
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
        <LinedTitle title="Companies">
            <button @click.prevent="modalState = true" class="btn primary sm">Add a new company</button>
        </LinedTitle>

        <ItemsDisplay
            :data="companies"
            :dataRender="[{ name: 'Name', key: 'name', searchable: true }]"
            class="mt-8"
        >
            <template #listItem="{ item }">
                <div class="flex flex-col">
                    <span class="font-bold">{{ item.name }}</span>
                    <span class="text-sm text-gray-500">{{ item.key }}</span>
                </div>
            </template>
            <template #preview="{ item }">
                <dt>Invitation Code</dt>
                <dd @click.prevent="copyToClipboard(item.key)" class="cursor-pointer hover:!text-dogger-orange-400">
                    {{ item.key }}
                </dd>
            </template>
        </ItemsDisplay>
    
        <ModalLayout :state="modalState" @close="modalState = false" additionalClasses="card max-w-3xl w-full">
            <LinedTitle title="Add a new company" />
            <form @submit.prevent="submit" class="flex flex-col gap-5 lg:gap-6 mt-12">
                <InputWapper
                    v-model="form.name"
                    :error="form.errors.name"
                    :required="true"
                    title="Name"
                />
                <button class="btn primary sm float-right" type="submit">Submit</button>
            </form>
        </ModalLayout>
    </DashboardLayout>
</template>

<style lang="scss" scoped></style>