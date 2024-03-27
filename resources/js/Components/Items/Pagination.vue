<script setup>
import { watch } from 'vue';
import { useI18n } from 'vue-i18n';
import { usePage, useForm } from '@inertiajs/vue3';
import { ChevronLeftIcon, ChevronRightIcon } from '@heroicons/vue/24/outline';

const { t } = useI18n({});

const props = defineProps({
    paginator: {
        type: Object,
        required: true
    },
    pageName: {
        type: String,
        default: 'page'
    },
    perPageSelect: {
        type: Boolean,
        default: false
    }
});

const allParams = usePage().props.route.query;

const form = useForm({
    ...allParams,
    perPage: allParams.perPage ?? props.paginator.per_page,
    [props.pageName]: allParams[props.pageName] ?? props.paginator.current_page
});

const isPreviousButton = (key) => key === 0;
const isNextButton = (key) => key === props.paginator.links.length - 1;
const isDisabled = (key, url) => {
    return (props.paginator.current_page - 1 === 0 && key === 0)
        || (props.paginator.current_page === props.paginator.last_page && key === props.paginator.links.length - 1)
        || url === null;
};

watch(() => form.isDirty, (newVal) => {
    if (newVal) {
        form.get(props.paginator.path, {
            preserveScroll: true,
            preserveState: false,
        });
    }
});

const setPage = (link) => {
    if (!link.url) return;
    const value = new URL(link.url).searchParams.get(props.pageName);
    form[props.pageName] = value;
};
</script>

<template>
    <div v-if="paginator.total > 0" class="grid grid-cols-3 sm:grid-cols-5 gap-5 items-center p-3">
        <div class="text-sm text-gray-700 hidden sm:block">
            {{ paginator.total }} {{t('results')}}
        </div>
        <div class="col-span-3 flex gap-5 justify-center items-center">
            <button
                v-if="paginator.links.length > 3"
                v-for="(link, key) in paginator.links"
                @click="setPage(link)"
                :key="`link-${key}`"
                :class="{ 'disabled' : isDisabled(key, link.url) }"
                class="hover:text-dogger-orange-400"
            >
                <ChevronLeftIcon v-if="isPreviousButton(key)" class="w-8 h-8 px-1" />
                <ChevronRightIcon v-else-if="isNextButton(key)" class="w-8 h-8 px-1" />
                <span v-else :class="{ 'text-dogger-orange-400' : link.active }" class="text-lg">
                    {{ link.label }}
                </span>
            </button>
        </div>
        <div v-if="perPageSelect" class="hidden sm:block ml-auto">
            <select v-model="form.perPage">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
            </select>
        </div>
    </div>
</template>

<style lang="scss" scoped>
    .disabled {
        @apply cursor-not-allowed pointer-events-none text-dogger-gray-light;
    }
</style>