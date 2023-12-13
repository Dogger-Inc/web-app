<script setup>
import { computed } from 'vue';

const emits = defineEmits(['update:modelValue']);
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
        default: 'Aucune option'
    },
    placeholder: {
        type: String,
        default: 'Sélectionner une option'
    },
    modelValue: [Object, String, Number],
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

const value = computed({
    get: () => props.modelValue,
    set: (val) => emits('update:modelValue', val)
});

const id = computed(() => {
    // slug the title and add random string to avoid duplicate ids
    const slug = props.title.toLowerCase().replace(/\s/g, '-');
    const randomizer = Math.random().toString(36).substring(2, 9);
    return `${randomizer}-${slug}`;
});

const getOptValue = (opt) => {
    if (props.reduce) {
        return opt[props.reduce];
    }
    return opt;
};
</script>

<template>
    <div :class="['pt-3 relative', {'form-error-div': error}]">
        <label :for="id">
            {{ title }}
            <span v-if="required" class="text-red-500 ml-0.5">*</span>
        </label>
        <select
            v-model="value"
            :id="id"
            :required="required"
            :disabled="disabled"
        >
            <option v-if="options.length === 0" disabled value="">{{ noOptText }}</option>
            <option v-else disabled value="">{{ placeholder }}</option>
            <option v-for="(opt, index) in options" :key="index" :value="getOptValue(opt)">
                {{ opt[label] }}
            </option>
        </select>
        <div v-if="error" class="form-error-field">{{ error }}</div>
    </div>
</template>

<style lang="scss" scoped>
label {
    @apply block px-3 text-sm font-normal text-gray-500 pointer-events-none;
    position: inherit;
    z-index: 2;
}

select {
    @apply w-full bg-transparent rounded-xl border-2 border-gray-400 shadow-sm sm:text-sm font-medium pt-8 pb-2 px-2 -mt-8 indent-0.5;

    // Use the following code to replace the default arrow
    -webkit-appearance: none;
    -moz-appearance: none;
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

    &:disabled {
        @apply bg-gray-200 cursor-not-allowed opacity-100;
    }
}
</style>
