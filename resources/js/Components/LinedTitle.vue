<script setup>
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
</script>

<template>
    <section class="flex justify-between flex-col md:flex-row gap-10 md:gap-4">
        <div class="relative w-fit">
            <h3
                v-if="sm"
                class="font-medium text-xl w-fit"
                :class="{'truncate': truncate}"
            >
                {{ title }}
            </h3>
            <h1
                v-else
                class="font-bold text-2xl w-fit"
                :class="{'truncate': truncate}"
            >
                {{ title }}
            </h1>
            <div class="rounded-lg bg-dogger-orange-500 absolutee w-3/4" :class="[sm ? 'h-1 mt-1.5' : 'h-1.5 mt-2']" />
        </div>
        <slot />
    </section>
</template>
