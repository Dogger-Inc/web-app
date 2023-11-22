<script setup>
import { useSlots } from 'vue';
import { ref, computed, watch } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { ChevronRightIcon } from '@heroicons/vue/24/outline';
import Pagination from '@/Components/Items/Pagination';
import SearchBar from '@/Components/Items/SearchBar';

const slots = useSlots();
const emits = defineEmits(['selectedItem']);
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
    selectedItem : Object,
});

const newData = ref([]);
const hasData = computed(() => newData.value.length > 0);
const hasSearch = usePage().props.route.query.search ? true : false;

watch(() => props.data, (newVal) => {
    newData.value = props.pagination ? newVal.data : newVal;

    if(newData.value.length === 1) {
        emits('selectedItem', newData.value[0]);
    }
}, { deep: true, immediate: true });

const select = (item) => {
    emits('selectedItem', item);
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
                :class="{
                    'bg-dogger-gray': selectedItem === item,
                    'hover:cursor-pointer': selectedCallback
                }"
                class="hover:bg-dogger-gray"
            >
                <div v-if="slots.default" class="inline-flex gap-4 items-center truncate">
                    <slot :item="item" />
                </div>
                <div class="inline-flex gap-2 items-center">
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
    @apply p-0 col-span-2 flex flex-col justify-between;

    ul {
        @apply relative mt-3 h-full;

        li {
            @apply flex justify-between items-center px-3 sm:px-5 py-3;
        }

        li.no-data {
            @apply justify-center h-full;
        }
    }
}
</style>
