<script setup>
import { computed, useSlots } from 'vue';
import { usePage, router } from '@inertiajs/vue3';
import { ChevronRightIcon } from '@heroicons/vue/24/outline';
import Pagination from '@/Components/Items/Pagination.vue';
import SearchBar from '@/Components/Items/Searchbar.vue';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const slots = useSlots();
const props = defineProps({
    data : {
        type: Object,
        required: true
    },
    pagination: {
        type: Object,
        default: () => ({enabled: true, perPageSelect: true, pageName: 'page'})
    },
    placeholder: {
        type: String,
    },
    searchbar : {
        type: Boolean,
        default: true
    },
    searchByOpts : Array,
    detailsPath : String,
});
const placeholderToShow = computed( () => props.placeholder || t("no_data") )
const hasSearch = usePage().props.route.query.search ? true : false;

const newData = computed(() => paginationOpts.value.enabled ? props.data.data : props.data);
const hasData = computed(() => newData.value.length > 0);
const isClickable = computed(() => props.detailsPath ? true : false);
const paginationOpts = computed(() => ({
    enabled: props.pagination.enabled,
    perPageSelect: props.pagination.perPageSelect,
    pageName: props.pagination.pageName
}));

const select = (item) => {
    if(!props.detailsPath) return;
    router.get(route(props.detailsPath, item.id));
}
</script>

<template>
    <div class="card alt">
        <SearchBar v-if="searchbar" :searchByOpts="searchByOpts" />
        <ul>
            <li
                v-if="hasData"
                v-for="item in newData"
                :key="item.id"
                @click="select(item)"
                :class="{'cursor-pointer': isClickable}"
                class="hover:bg-dogger-gray-light rounded-lg"
            >
                <div v-if="slots.default" class="inline-flex gap-4 items-center truncate">
                    <slot v-bind="item" />
                </div>
                <div v-if="isClickable" class="inline-flex gap-2 items-center">
                    <ChevronRightIcon class="h-5 w-5 text-wiibus-black hidden sm:block" />
                </div>
            </li>
            <li v-else-if="hasSearch" class="no-data">{{$t('no_result')}}</li>
            <li v-else class="no-data">{{ placeholderToShow }}</li>
        </ul>
        <Pagination
            v-if="hasData && paginationOpts.enabled"
            :paginator="data"
            :per-page-select="paginationOpts.perPageSelect"
            :page-name="paginationOpts.pageName"
        />
    </div>
</template>

<style lang="scss" scoped>
.card.alt {
    @apply p-0 col-span-2 flex flex-col justify-between w-full;

    ul {
        @apply relative h-full;

        li {
            @apply flex justify-between items-center px-3 sm:px-5 py-3;
        }

        li.no-data {
            @apply justify-center h-full;
        }
    }
}
</style>
