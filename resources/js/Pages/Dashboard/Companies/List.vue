<script setup>
import { ref, computed } from 'vue';
import { useForm, router } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import { XMarkIcon } from '@heroicons/vue/24/outline';
import ModalLayout from '@/Layouts/Modal.vue';
import ItemsList from '@/Components/Items/List.vue';
import DashboardLayout from '@/Layouts/Dashboard.vue';
import InputWapper from '@/Components/Form/InputWrapper.vue';
import LinedTitle from '@/Components/LinedTitle.vue';

const { t } = useI18n({});

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
            <div v-if="hasCompanies" class="flex flex-row gap-4">
                <button @click.prevent="modalStateAdd = true" class="btn primary sm">
                    {{t("companies.add")}}
                </button>
                <button @click.prevent="modalStateJoin = true" class="btn primary sm">
                    {{t("companies.join_existing")}}
                </button>
            </div>
        </LinedTitle>

        <ItemsList
            v-if="hasCompanies"
            :data="companies"
            :searchByOpts="[{ name: t('companies.name'), key: 'name' }]"
            detailsPath="dashboard.companies.details"
            class="mt-8"
            v-slot="item"
        >
            <div class="flex flex-col">
                <span class="font-bold">{{ item.name }}</span>
                <span class="text-sm text-gray-500">{{ item.key }}</span>
            </div>
        </ItemsList>

        <div v-else class="mt-14 w-full gap-28 text-center">
            <h3 class="text-2xl">{{ t("companies.not_registred_to_company") }}</h3>

            <div class="flex justify-center gap-28 mt-8">
                <button @click="modalStateJoin = true" class="btn primary sm">
                    {{t("companies.join")}}
                </button>
                <button @click="modalStateAdd = true" class="btn primary sm">
                    {{t("companies.create")}}
                </button>
            </div>
        </div>


        <!-- Forms section below -->
        <ModalLayout :state="modalStateAdd" @close="modalStateAdd = false" additionalClasses="card max-w-3xl w-full">
            <LinedTitle :title="t('companies.add')" />

            <form @submit.prevent="submit('add')">
                <InputWapper
                    v-model="formAdd.name"
                    :title="t('companies.name')"
                    :error="formAdd.errors.name"
                    :required="true"
                />
                <button class="btn primary sm" type="submit">
                    {{ t("submit") }}
                </button>
            </form>
            <div @click="modalStateAdd = false" class="absolute right-2 top-2 h-6 w-6 flex justify-center items-center cursor-pointer hover:text-red-500">
                <XMarkIcon/>
            </div>
        </ModalLayout>

        <ModalLayout :state="modalStateJoin" @close="modalStateJoin = false" additionalClasses="card max-w-3xl w-full">
            <LinedTitle title="Join a company" />

            <form @submit.prevent="submit('join')">
                <InputWapper
                    v-model="formJoin.key"
                    :title="t('companies.invitation_code')"
                    :error="formJoin.errors.key"
                    :required="true"
                />
                <button class="btn primary sm" type="submit">
                    {{ t("submit") }}
                </button>
            </form>
            <div @click="modalStateJoin = false" class="absolute right-2 top-2 h-6 w-6 flex justify-center items-center cursor-pointer hover:text-red-500">
                <XMarkIcon/>
            </div>
        </ModalLayout>
    </DashboardLayout>
</template>

<style lang="scss" scoped>
form {
    @apply flex flex-col gap-5 lg:gap-6 mt-12;
}
</style>