<script setup>
import { ref, watch } from 'vue';
import { router, usePage } from "@inertiajs/vue3";
import { ChevronLeftIcon, ChevronRightIcon } from '@heroicons/vue/24/outline';

const props = defineProps({
    paginator: {
        type: Object,
        required: true,
    },
    reloadProps: Array,
});

const urlParams = ref({});

watch(() => usePage().props.route.query, (params) => {
    delete params.page;
    urlParams.value = params;
}, { deep: true, immediate: true });

const isPreviousButton = (key) => key === 0;
const isNextButton = (key) => key === props.paginator.links.length - 1;
const isDisabled = (key) => {
    return (props.paginator.current_page - 1 === 0 && key === 0)
        || (props.paginator.current_page === props.paginator.last_page && key === props.paginator.links.length - 1);
};

const control = (url) => {
    if(url) {
        if(props.reloadProps) {
            router.get(url, urlParams.value, { preserveScroll: true, preserveState: true, only: props.reloadProps });
        } else {
            router.get(url, urlParams.value, { preserveScroll: true, preserveState: false });
        }
    }
}
</script>

<template>
    <template v-if="paginator.links.length > 3">
        <div class="flex gap-5 p-3 justify-center items-center">
            <template v-for="(link, key) in paginator.links" :key="`link-${key}`">
                <button
                    v-if="isPreviousButton(key)" @click.prevent="control(link.url)"
                    class="hover:text-dogger-orange-400"
                    :class="{'disabled': isDisabled(key)}"
                >
                    <ChevronLeftIcon class="w-8 h-8 px-1" />
                </button>
                <button
                    v-else-if="isNextButton(key)" @click.prevent="control(link.url)"
                    class="hover:text-dogger-orange-400"
                    :class="{'disabled': isDisabled(key)}"
                >
                    <ChevronRightIcon class="w-8 h-8 px-1" />
                </button>
                <button
                    v-else-if="link.active" @click.prevent="control(link.url)"
                    v-html="link.label" class="text-dogger-orange-400 text-lg"
                    :class="{'disabled': isDisabled(key)}"
                />
            </template>
        </div>
    </template>
</template>

<style lang="scss" scoped>
    .disabled {
        @apply cursor-not-allowed pointer-events-none text-dogger-gray-light;
    }
</style>
