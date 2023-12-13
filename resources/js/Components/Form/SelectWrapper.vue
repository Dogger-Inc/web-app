<script setup>
import { computed } from 'vue';
import VueSelect from "vue-select";

const emits = defineEmits(['update:modelValue']);
const props = defineProps({
    title: {
        type: String,
        required: true
    },
    modelValue: [Object, String, Number],
    options: {
        type: Array,
        required: true
    },
    label: {
        type: String,
        default: 'name'
    },
    reduce: String,
    noOptText: {
        type: String,
        default: 'Aucune option'
    },
    error: String,
    disabled : Boolean,
    required: {
        type: Boolean,
        default: true
    },
});

const value = computed({
    get: () => props.modelValue,
    set: (val) => emits('update:modelValue', val)
});

const reduce = computed(() => {
    if (props.reduce) {
        return option => option[props.reduce];
    }
    return option => option;
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
        <VueSelect
            :id="id"
            :options="options"
            :label="label"
            :reduce="reduce"
            :disabled="disabled"
            :required="required"
            v-model="value"
        >
            <template #no-options>{{ noOptText }}</template>
        </VueSelect>
        <div v-if="error" class="form-error-field">{{ error }}</div>
    </div>
</template>

<style lang="scss" scoped>
label {
    @apply block px-3 text-sm font-normal text-gray-500 pointer-events-none;
    position: inherit;
    z-index: 2;
}

.v-select {
    @apply block w-full sm:text-sm font-semibold rounded-xl border-gray-400 border-2 shadow-sm -mt-8;

    &:disabled {
        @apply bg-gray-200 cursor-not-allowed;
    }
}
</style>

<style lang="scss">
// we need to override some of the vue-select styles but we can't use scoped styles
.v-select {
    .vs__dropdown-toggle {
        @apply border-none rounded-xl pt-[30px] pb-1.5 px-[10px] m-0;

        .vs__search, .vs__selected-options {
            padding: 0;
            margin: 0;
        }
        .vs__selected {
            @apply pl-0 pr-2 m-0;
        }
        .vs__actions {
            @apply p-0 -mt-5 mr-1.5;
        }
    }

    &.vs--open {
        @apply border-dogger-orange-500;
    }
}
</style>
