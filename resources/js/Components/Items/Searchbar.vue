<script setup>
import { ref, computed, watch, onMounted } from 'vue';
import { usePage, router, useForm } from "@inertiajs/vue3";
import {
    MagnifyingGlassIcon,
    ArrowSmallDownIcon,
    ArrowSmallUpIcon
} from '@heroicons/vue/24/outline';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const props = defineProps({
    searchByOpts: {
        type: Array,
        required: false,
        default: () => [],
    },
});

const searchBar = ref(null);
const urlSearch = computed(() => usePage().props.route.query.search);
const urlOrderBy = computed(() => usePage().props.route.query.orderBy);
const currentRouteName = usePage().props.route.name;

const form = useForm({
    search: urlSearch.value || '',
    searchBy: usePage().props.route.query.searchBy ?? props.searchByOpts[0]?.key,
    orderBy: urlOrderBy.value
});

const debounce = (fct, delay) => {
    let debounceTimer;
    return function() {
        const context = this;
        const args = arguments;
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => fct.apply(context, args), delay);
    }
}

onMounted(() => {
    searchBar.value.focus();
});

watch(form, (val) => {
    if(val.orderBy === urlOrderBy.value) {
        if(!urlSearch.value && !val.search) return;
        if(val.search === urlSearch.value) return;
    }

    const debouncedFunction = debounce(() => {
        if (val.search.length > 0) {
            if (!val.orderBy) val.orderBy = 'ASC';
            form.get(route(currentRouteName), { preserveScroll: true, preserveState: true });
        } else if (val.orderBy) {
            router.get(route(currentRouteName), { orderBy: val.orderBy }, { preserveScroll: true, preserveState: true });
        }
    }, 200);
    debouncedFunction();
});
</script>

<template>
    <div class="flex border-b border-dogger-gray divide-x divide-dogger-gray mb-3">
        <div class="relative w-full">
            <input
                v-model="form.search"
                type="text"
                ref="searchBar"
                :placeholder="t('research')"
                class="block w-full rounded-md pl-4 pr-10 py-2"
            />
            <div class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer">
                <MagnifyingGlassIcon class="w-4 h-4" />
            </div>
        </div>
        <div v-if="searchByOpts.length > 0" class="hidden sm:block px-4 py-2 min-w-[25%]">
            <select v-model="form.searchBy" class="w-full">
                <option disabled value="">{{t('research_by')}}</option>
                <option v-for="opt in searchByOpts" :key="opt.key" :value="opt.key">
                    {{ opt.name }}
                </option>
            </select>
        </div>
        <div class="px-3 py-2 flex justify-center items-center">
            <button
                type="button"
                title="Trier par ordre croissant/décroissant"
                @click.prevent="form.orderBy = form.orderBy === 'DESC' ? 'ASC' : 'DESC'"
            >
                <ArrowSmallUpIcon v-if="form.orderBy === 'DESC'" class="w-5 h-5" />
                <ArrowSmallDownIcon v-else class="w-5 h-5" />
            </button>
        </div>
    </div>
</template>
