<template>
    <div class="bg-gray-100 border border-gray-200 w-full rounded-md text-sm overflow-hidden min-h-32">
        <div v-for="(row, index) in rows" :key="`stacktrace-${index}`" class="w-full flex flex-row items-center gap-2">
            <span class="bg-gray-200 h-full px-2 text-gray-400">{{ index + 1 }}</span>
            <span>{{ row }}</span>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    text: {
        type: String,
        required: true,
    }
})

const rows = computed(() => props.text.split(/\r?\n/));
</script>
