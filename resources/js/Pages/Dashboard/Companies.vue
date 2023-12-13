<script setup>
import { ref, computed } from 'vue';
import { useForm, router } from '@inertiajs/vue3';
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

const modalStateAdd = ref(false);
const modalStateJoin = ref(false);
const hasCompanies = computed(() => props.companies.data.length > 0);

const formAdd = useForm({
    name: '',
});

const formJoin = useForm({
    key: '',
});

const copyToClipboard = (text) => {
    navigator.clipboard.writeText(text);
    toast.success('Copied to clipboard');
};

const submit = (addOrJoin) => {
    if(addOrJoin === "add") {
            formAdd.post(route('dashboard.companies.create.post'), {
            onStart: () => formAdd.clearErrors(),
            onSuccess() {
                modalStateAdd.value = false;
                formAdd.reset();
            },
        });
    }
    else {
        router.get(route('dashboard.companies.join', formJoin.key), {
            onStart: () => formJoin.clearErrors(),
            onSuccess() {
                modalStateJoin.value = false;
                formJoin.reset();
            },
        });
    }    
};
</script>

<template>
    <DashboardLayout>
        <LinedTitle title="Companies">
            <div class="flex flex-row gap-4">
            <button v-if="hasCompanies" @click.prevent="modalStateAdd = true" class="btn primary sm">
                Add a new company
            </button>
            <button v-if="hasCompanies" @click.prevent="modalStateJoin = true" class="btn primary sm">
                Join an existing company
            </button>
        </div>
        </LinedTitle>

        <ItemsDisplay v-if="hasCompanies" :data="companies" :dataRender="[{ name: 'Name', key: 'name', searchable: true }]"
            class="mt-8">
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

        <div v-else class="mt-14 w-full gap-28 text-center">
            <h3 class="text-2xl">You are not register to any company</h3>
            <div class="flex justify-center gap-28 mt-8">
                <button @click="modalStateJoin = true" class="btn primary sm">Join a company</button>
                <button @click="modalStateAdd = true" class="btn primary sm">Create a company</button>
            </div>
        </div>

        <ModalLayout :state="modalStateAdd" @close="modalStateAdd = false" additionalClasses="card max-w-3xl w-full">
            <LinedTitle title="Add a new company" />
            <form @submit.prevent="submit('add')" class="flex flex-col gap-5 lg:gap-6 mt-12">
                <InputWapper v-model="formAdd.name" :error="formAdd.errors.name" :required="true" title="Name" />
                <button class="btn primary sm float-right" type="submit">Submit</button>
            </form>
        </ModalLayout>

        <ModalLayout :state="modalStateJoin" @close="modalStateJoin = false" additionalClasses="card max-w-3xl w-full">
            <LinedTitle title="Join a company" />
            <form @submit.prevent="submit('join')" class="flex flex-col gap-5 lg:gap-6 mt-12">
                <InputWapper v-model="formJoin.key" :error="formJoin.errors.key" :required="true" title="Invitation code" />
                <button class="btn primary sm float-right" type="submit">Submit</button>
            </form>
        </ModalLayout>
    </DashboardLayout>
</template>

<style lang="scss" scoped></style>