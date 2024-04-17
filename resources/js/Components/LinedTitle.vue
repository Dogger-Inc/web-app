<script setup>
import { ref, computed } from 'vue';

const props = defineProps({
    title: {
        type: String,
        required: true
    },
    sm: {
        type: Boolean,
        required: false,
        default: false
    },
    truncate: {
        type: Boolean,
        required: false,
        default: false
    }
});

const titleRef = ref(null);

// if you won't use dynamic width you can simply use "w-28" tailwind class (112px)
const lineWidth = computed(() => {
    const width = Math.round(titleRef.value?.clientWidth * 0.75) || 112;
    return `${width}px`;
});
</script>

<template>
    <section class="flex justify-between flex-col md:flex-row gap-10 md:gap-4">
        <div class="relative">
            <h3
                v-if="sm"
                ref="titleRef"
                class="font-medium text-xl w-fit"
                :class="{
                    'truncate w-9/12': truncate,
                }"
            >
                {{ title }}
            </h3>
            <h1
                v-else
                ref="titleRef"
                class="font-bold text-2xl w-fit"
                :class="{
                    'truncate w-9/12': truncate,
                }"
            >
                {{ title }}
            </h1>
            <div class="rounded-lg bg-dogger-orange-500 absolute" :class="[sm ? 'h-1 mt-1.5' : 'h-1.5 mt-2']" :style="{width: lineWidth}" />
        </div>
        <slot />
    </section>
</template>
