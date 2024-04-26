<script setup>
import { useI18n } from 'vue-i18n';
import { useToast } from 'vue-toastification';
import DataCell from '@/Components/Items/DataCell.vue';
import InputWrapper from '@/Components/Form/InputWrapper.vue';
import { ref } from 'vue';
import { useForm, router } from '@inertiajs/vue3';

const { t } = useI18n({});
const toast = useToast();

const props = defineProps({
    project: {
        type: Object,
        required: true,
    },
});

const showUpdateForm = ref(false);
const updateForm = useForm({
    project_id: props.project.id,
    name: props.project.name,
    errors: {
        name: false
    }
});

const copyToClipboard = (text) => {
    navigator.clipboard.writeText(text);
    toast.success(t("copied"));
};

const handleUpdateProject = () => {
    updateForm.patch(route('dashboard.projects.update.patch'), {
        onStart: () => updateForm.clearErrors(),
        onSuccess() {
            showUpdateForm.value = false;
            updateForm.reset();
        },
    });
}

const handleUpdateProjectCode = () => {
    router.patch(
        route('dashboard.projects.refresh_code.patch', props.project?.id),
        {},
        { preserveState: false }
    );
}
</script>

<template>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="grid grid-cols-1">
            <div v-if="!showUpdateForm" class="space-y-2">
                <DataCell :title="t('name')" :value="project.name" :spacer="false" />
                <button
                    v-if="project.editable"
                    @click.prevent="showUpdateForm = true"
                    class="btn primary sm mt-3"
                >
                    {{ t('projects.edit') }}
                </button>
            </div>
            <form v-else @submit.prevent="handleUpdateProject" class="space-y-2 py-4">
                <InputWrapper
                    v-model="updateForm.name"
                    :error="updateForm.errors.name"
                    :required="true"
                    :title="t('name')"
                />
                <div class="flex flex-row items-center gap-2">
                    <button
                        type="submit"
                        class="btn primary sm mt-3"
                    >
                        {{ t('projects.update') }}
                    </button>
                    <button
                        @click.prevent="showUpdateForm = false"
                        class="btn generic sm mt-3"
                    >
                        {{ t('projects.cancel') }}
                    </button>
                </div>
            </form>
        </div>
        <div>
            <DataCell
                :title="t('projects.key')"
                :value="project.key"
                @click.prevent="copyToClipboard(project.key)"
                class="sm:border-t-0"
            />
            <button
                v-if="project.editable"
                @click.prevent="handleUpdateProjectCode"
                class="btn generic sm mt-3"
            >
                {{ $t('companies.change_code')}}
            </button>
        </div>
    </div>
</template>
