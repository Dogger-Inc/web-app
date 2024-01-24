<script setup>
defineProps({
    title: {
        type: String,
        required: true,
    },
    bgColor: {
        type: String,
        default: 'bg-gray-100',
    },
});
</script>

<template>
    <span
        class="rounded-full px-2 py-1 text-xs font-medium text-gray-600"
        :class="bgColor"
    >
        {{ title }}
    </span>
</template>