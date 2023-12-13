<script setup>
/**
 * @example
        import ItemsDisplay from '@/Components/Items/Display.vue';

        <ItemsDisplay
            :data="companies"
            :dataRender="[
                {name: 'Nom', key: 'name', searchable: true},
                {name: 'Clé', key: 'key'},
            ]"
        >
            <template #listItem="{item}">
                <div class="flex flex-col">
                    <span class="font-bold">{{ item.name }}</span>
                    <span class="text-sm text-gray-500">{{ item.key }}</span>
                </div>
            </template>
        </ItemsDisplay>
*/


import { ref, computed } from 'vue';
import ItemsList from '@/Components/Items/List.vue';
import ItemPreview from '@/Components/Items/Preview.vue';

const props = defineProps({
    data: {
        type: Object,
        required: true
    },
    pagination: {
        type: Boolean,
        default: true
    },
    dataRender: {
        type: Array,
        default: () => []
    },
    showIdIfAdmin: {
        type: Boolean,
        default: true
    },
    titleKey: {
        type: String,
        default: 'name'
    },
    editKey: {
        type: String,
        default: 'id'
    },
    editPath: String
});

const selectedItem = ref(null);
const searchByOpts = computed(() => {
    return props.dataRender.filter(item => item.searchable).map(item => {
        return {
            name: item.name,
            key: item.key
        }
    });
});
</script>

<template>
    <div class="flex w-full gap-4">
        <ItemsList
            :data="data"
            :selectedItem="selectedItem"
            :pagination="pagination"
            :searchByOpts="selectedItem ? [] : searchByOpts"
            :class="{ 'w-full lg:w-1/3': selectedItem, 'w-full': !selectedItem}"
            class="transition-all duration-300"
            @selected-item="(value) => selectedItem = value"
            v-slot="item"
        >
            <slot name="listItem" :item="item.item" />
        </ItemsList>

        <ItemPreview
            v-if="selectedItem"
            :titleKey="titleKey"
            :editKey="editKey"
            :editPath="editPath"
            :selectedItem="selectedItem"
            :showIdIfAdmin="showIdIfAdmin"
            :dataRender="dataRender"
            @close="selectedItem = null"
            v-slot="item"
        >
            <slot name="preview" :item="item" />
        </ItemPreview>
    </div>
</template>