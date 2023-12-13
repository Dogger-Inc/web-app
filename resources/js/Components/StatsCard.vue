<script setup>
import { computed } from 'vue';

const props = defineProps({
    title: {
        type: String,
        required: true
    },
    value: {
        type: Number,
        required: true
    },
    percentage: {
        type: String,
        required: false
    },
    icon: {
        type: Function,
        required: true
    },
    iconBg: {
        type: String,
        required: false,
        default: 'bg-dogger-orange-400'
    },
    clickable: Boolean,
})

const bgIconClass = computed(() => {
    return `flex justify-center items-center ${props.iconBg ?? 'bg-dogger-orange-500'} p-2 rounded-full w-10 h-10 text-white text-xl`;
});
</script>

<template>
    <div :class="[{'hover:bg-gray-50' :clickable}, 'overflow-hidden rounded-lg bg-white shadow flex items-center p-5']">
        <dl>
            <dt>{{ title }}</dt>
            <dd>
                {{ value }}
                <span v-if="percentage">{{ percentage }}</span>
            </dd>
        </dl>
        <div :class="bgIconClass">
            <component :is="icon" />
        </div>
    </div>
</template>

<style lang="scss" scoped>
dl {
    @apply mr-5 w-0 flex-1;

    dt {
        @apply truncate text-sm font-medium text-gray-500;
    }

    dd {
        @apply text-lg font-medium text-gray-900;

        span {
            @apply text-red-500 ml-2 text-sm;
        }
    }
}
</style>