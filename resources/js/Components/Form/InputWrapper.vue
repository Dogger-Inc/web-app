<script setup>
import { computed, ref } from 'vue';
import { EyeIcon, EyeSlashIcon } from '@heroicons/vue/24/outline';

const emits = defineEmits(['update:modelValue']);
const props = defineProps({
    title: {
        type: String,
        required: true
    },
    modelValue: [String, Number],
    type: {
        type: String,
        default: 'text',
        validator(value) {
            return ['text', 'email', 'password', 'number', 'search', 'tel', 'url', 'date', 'datetime-local'].includes(value)
        }
    },
    placeholder: String,
    min: [String, Number],
    max: [String, Number],
    error: String,
    disabled : Boolean,
    required: {
        type: Boolean,
        default: true
    },
});

const inputType = ref(props.type);
const id = computed(() => {
    // slug the title and add random string to avoid duplicate ids
    const slug = props.title.toLowerCase().replace(/\s/g, '-');
    const randomizer = Math.random().toString(36).substring(2, 9);
    return `${randomizer}-${slug}`;
});

const updateValue = (event) => emits('update:modelValue', event.target.value);

const updatePasswordState = () => {
    inputType.value = inputType.value === 'password' ? 'text' : 'password';
};
</script>

<template>
    <div :class="{'form-error-div': error}">
        <div class="pt-3 relative">
            <label :for="id">
                {{ title }}
                <span v-if="required" className="text-red-500 ml-0.5">*</span>
            </label>
            <input v-if="type !== 'number' && type !== 'date' && type !== 'datetime-local'"
                :id="id"
                :type="inputType"
                :placeholder="placeholder"
                :value="modelValue"
                :disabled="disabled"
                :required="required"
                @input="updateValue"
            >
            <input v-else
                :id="id"
                :type="inputType"
                :placeholder="placeholder"
                :min="min"
                :max="max"
                :value="modelValue"
                :disabled="disabled"
                :required="required"
                @input="updateValue"
            >
            <span class="absolute top-1/2 right-5 -translate-y-1/2" @click.prevent="updatePasswordState">
                <EyeIcon v-if="type === 'password' && inputType === 'password'"/>
                <EyeSlashIcon v-else-if="type === 'password' && inputType === 'text'"/>
            </span>
        </div>
        <div v-if="error" class="form-error-field">{{ error }}</div>
    </div>
</template>

<style lang="scss" scoped>
label {
    @apply block px-3 text-sm font-normal text-gray-500 pointer-events-none;
}

input {
    @apply block w-full rounded-xl border-2 border-gray-400 shadow-sm sm:text-sm font-semibold pt-8 pb-2 px-3 -mt-8;

    &:focus {
        @apply border-dogger-orange-500;
    }
    &:disabled {
        @apply bg-gray-200 cursor-not-allowed;
    }
}

svg {
    @apply cursor-pointer h-6 w-6 text-gray-500;
}
</style>
