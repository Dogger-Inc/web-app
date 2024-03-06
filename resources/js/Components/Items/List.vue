<script setup>
import { ref, computed, watch, useSlots } from 'vue';
import { usePage, router } from '@inertiajs/vue3';
import { ChevronRightIcon } from '@heroicons/vue/24/outline';
import Pagination from '@/Components/Items/Pagination.vue';
import SearchBar from '@/Components/Items/Searchbar.vue';

const slots = useSlots();
const props = defineProps({
    data : {
        type: Object,
        required: true
    },
    pagination : {
        type: Boolean,
        default: true
    },
    searchbar : {
        type: Boolean,
        default: true
    },
    searchByOpts : Array,
    detailsPath : String,
});

const newData = ref([]);
const hasData = computed(() => newData.value.length > 0);
const hasSearch = usePage().props.route.query.search ? true : false;
const isClickable = computed(() => props.detailsPath ? true : false);

watch(() => props.data, (newVal) => {
    newData.value = props.pagination ? newVal.data : newVal;
}, { deep: true, immediate: true });

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
            <li v-else-if="hasSearch" class="no-data">Aucun résultat</li>
            <li v-else class="no-data">Aucune donnée</li>
        </ul>
        <Pagination v-if="hasData && pagination" :paginator="data" />
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
