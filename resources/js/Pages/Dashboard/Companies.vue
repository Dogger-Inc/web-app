<script setup>
import { ref, computed } from 'vue';
import { useForm, router } from '@inertiajs/vue3';
import { useToast } from 'vue-toastification';
import ModalLayout from '@/Layouts/Modal.vue';
import ItemsDisplay from '@/Components/Items/Display.vue';
import DashboardLayout from '@/Layouts/Dashboard.vue';
import InputWapper from '@/Components/Form/InputWrapper.vue';
import LinedTitle from '@/Components/LinedTitle.vue';
import { useI18n } from "vue-i18n";

const { t } = useI18n({});

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
    toast.success(t("companies.copied"));
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
        <LinedTitle :title="t('companies.companies')">
            <div v-if="hasCompanies" class="flex flex-row gap-4">
                <button @click.prevent="modalStateAdd = true" class="btn primary sm">
                    {{t("companies.add")}}
                </button>
                <button @click.prevent="modalStateJoin = true" class="btn primary sm">
                    {{t("companies.join_existing")}}
                </button>
            </div>
        </LinedTitle>

        <ItemsDisplay
            v-if="hasCompanies"
            :data="companies"
            :dataRender="[{ name: t('companies.name'), key: 'name', searchable: true }]"
            class="mt-8"
        >
            <template #listItem="{ item }">
                <div class="flex flex-col">
                    <span class="font-bold">{{ item.name }}</span>
                    <span class="text-sm text-gray-500">{{ item.key }}</span>
                </div>
            </template>
            <template #preview="{ item }">
                <dt>{{t("companies.invitation_code")}}</dt>
                <dd @click.prevent="copyToClipboard(item.key)" class="cursor-pointer hover:!text-dogger-orange-400">
                    {{ item.key }}
                </dd>
            </template>
        </ItemsDisplay>

        <div v-else class="mt-14 w-full gap-28 text-center">
            <h3 class="text-2xl">{{ t("companies.not_registred_to_company") }}</h3>
            <div class="flex justify-center gap-28 mt-8">
                <button @click="modalStateJoin = true" class="btn primary sm">{{t("companies.join")}}</button>
                <button @click="modalStateAdd = true" class="btn primary sm">{{t("companies.create")}}y</button>
            </div>
        </div>

        <ModalLayout :state="modalStateAdd" @close="modalStateAdd = false" additionalClasses="card max-w-3xl w-full">
            <LinedTitle :title="t('companies.add')" />
            <form @submit.prevent="submit('add')" class="flex flex-col gap-5 lg:gap-6 mt-12">
                <InputWapper v-model="formAdd.name" :error="formAdd.errors.name" :required="true" :title="t('companies.name')"/>
                <button class="btn primary sm float-right" type="submit">Submit</button>
            </form>
        </ModalLayout>

        <ModalLayout :state="modalStateJoin" @close="modalStateJoin = false" additionalClasses="card max-w-3xl w-full">
            <LinedTitle title="Join a company" />
            <form @submit.prevent="submit('join')" class="flex flex-col gap-5 lg:gap-6 mt-12">
                <InputWapper v-model="formJoin.key" :error="formJoin.errors.key" :required="true" :title="t('companies.invitation_code')" />
                <button class="btn primary sm float-right" type="submit">{{ t("companies.submit") }}</button>
            </form>
        </ModalLayout>
    </DashboardLayout>
</template>

<style lang="scss" scoped></style>