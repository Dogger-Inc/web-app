<script setup>
import { computed } from 'vue';

const modelValue = defineModel();
const props = defineProps({
    title: {
        type: String,
        required: true
    },
    placeholder: String,
    cols: {
        type: [String, Number],
        default: 30
    },
    rows: {
        type: [String, Number],
        default: 10
    },
    error: String,
    disabled : Boolean,
    required: {
        type: Boolean,
        default: true
    },
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
        <textarea
            :id="id"
            :disabled="disabled"
            :required="required"
            :placeholder="placeholder"
            :cols="cols"
            :rows="rows"
            v-model="modelValue">
        </textarea>
        <div v-if="error" class="form-error-field">{{ error }}</div>
    </div>
</template>

<style lang="scss" scoped>
label {
    @apply block px-3 text-sm font-normal text-gray-500 pointer-events-none;
}

textarea {
    @apply block w-full rounded-xl border-2 border-gray-400 shadow-sm sm:text-sm font-semibold pt-8 pb-2 px-3 -mt-8;

    &:focus {
        @apply border-dogger-orange-500;
    }
    &:disabled {
        @apply bg-gray-200 cursor-not-allowed;
    }
}

svg{
    @apply cursor-pointer h-6 w-6 text-gray-500;
}
</style>
