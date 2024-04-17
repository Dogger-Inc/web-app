<script setup>
import { computed } from 'vue';
import Multiselect from '@vueform/multiselect';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();
const modelValue = defineModel();
const props = defineProps({
    title: {
        type: String,
        required: true
    },
    options: {
        type: Array,
        required: true
    },
    label: {
        type: String,
        default: 'name'
    },
    noOptText: {
        type: String,
    },
    placeholder: {
        type: String,
    },
    reduce: String,
    error: String,
    required : {
        type: Boolean,
        default: false
    },
    disabled : {
        type: Boolean,
        default: false
    }
});

const noOptTextToShow = computed( () => props.noOptText || t("no_option") )
const placeholderToShow = computed( () => props.placeholder || t("select_many_options") )
const formatedOptions = computed(() => {
    return props.options.map((option) => {
        return {
            label: option[props.label],
            value: props.reduce ? option[props.reduce] : option
        };
    });
});

const id = computed(() => {
    // slug the title and add random string to avoid duplicate ids
    const slug = props.title.toLowerCase().replace(/\s/g, '-');
    const randomizer = Math.random().toString(36).substring(2, 9);
    return `${randomizer}-${slug}`;
});
</script>

<template>
    <div :class="['pt-3 relative', {'form-error-div': error}]">
        <label :for="id">
            {{ title }}
            <span v-if="required" class="text-red-500 ml-0.5">*</span>
        </label>
        <Multiselect
            :id="id"
            :options="formatedOptions"
            :placeholder="placeholderToShow"
            :required="required"
            :disabled="disabled"
            :close-on-select="false"
            :canClear="false"
            :searchable="true"
            :caret="false"
            :no-options-text="noOptTextToShow"
            v-model="modelValue"
            no-results-text="Aucun résultat"
            mode="tags"
        />
        <div v-if="error" class="form-error-field">{{ error }}</div>
    </div>
</template>

<style lang="scss" scoped>
label {
    @apply block px-3 text-sm font-normal text-gray-500 pointer-events-none;
    position: inherit;
    z-index: 2;
}

.multiselect {
    @apply w-full h-fit border-none block;

    &.is-active {
        @apply border-none shadow-none;
    }

    &.is-disabled :deep(.multiselect-wrapper) {
        @apply bg-gray-200 cursor-not-allowed;
    }

    :deep(.multiselect-wrapper) {
        @apply w-full rounded-xl border-2 border-gray-400 shadow-sm sm:text-sm font-medium pt-8 pb-2 px-2 -mt-8;

        background-image:
            linear-gradient(45deg, transparent 50%, gray 50%),
            linear-gradient(135deg, gray 50%, transparent 50%);
        background-position:
            calc(100% - 30px) calc(1.5rem + 4px),
            calc(100% - 24px) calc(1.5rem + 4px);
        background-size:
            6px 6px,
            6px 6px;
        background-repeat: no-repeat;

        .multiselect-placeholder {
            @apply w-full h-fit sm:text-sm font-medium text-black p-0 m-0 top-auto bottom-2 left-2.5;
        }

        .multiselect-tags {
            @apply p-0 pr-10 m-0;

            .multiselect-tags-search-wrapper {
                margin: 0;
                margin-left: 2px;
            }

            .multiselect-tag {
                margin: 0;
                margin-right: 4px;
                padding: 0;
                padding-left: 4px;
            }
        }
    }

    :deep(.multiselect-dropdown) {
        overflow-y: auto;
        border-radius: 5px;
    }
}
</style>
