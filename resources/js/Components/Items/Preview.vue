<script setup>
import { useSlots } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import { PencilSquareIcon, XMarkIcon } from '@heroicons/vue/24/outline';

const slots = useSlots();
const emits = defineEmits(['close']);
const props = defineProps({
    selectedItem: {
        type: Object,
        required: true
    },
    editKey: {
        type: String,
        default: 'id'
    },
    titleKey: {
        type: String,
        default: 'name'
    },
    dataRender: {
        type: Array,
        default: () => []
    },
    showIdIfAdmin: {
        type: Boolean,
        default: true
    },
    editPath: String
})

const userHasAccess = (waitedRoles) => {
    if(!waitedRoles || waitedRoles.length === 0) return true;
    // TODO : check user role using many to many relationship
    // return usePage().props.auth.user.roles.some((e) => waitedRoles.includes(e));
}

const displayCondition = (item) => {
    if(!item) return false;
    return userHasAccess(item.roles) && (!item.condition || item.condition());
}

const getValue = (key, isLinkKey = false, format) => {
    const keys = key.split('.');
    let value = props.selectedItem;

    keys.forEach((key) => {
        if(!value) return;
        value = value[key];
    });

    if(isLinkKey) return value;
    if(format && (value !== undefined && value !== null)) return format(value);
    return value || 'Non renseigné';
}

const close = () => {
    emits('close');
}
</script>

<template>
    <div class="card modal">
        <XMarkIcon @click.prevent="close" class="absolute top-4 right-4 h-5 w-5 cursor-pointer" />
        <!-- Title section -->
        <Link
            v-if="editPath"
            :href="route(editPath, getValue(editKey, true))"
            class="inline-flex gap-3 items-center"
        >
            <h3 class="capitalize hover:text-dogger-orange-400 font-bold truncate">
                {{ getValue(titleKey) }}
            </h3>
            <PencilSquareIcon class="h-5 w-5 text-dogger-orange-400" />
        </Link>
        <h3 v-else class="capitalize text-dogger-orange-400">{{ getValue(titleKey) }}</h3>
        <p v-if="userHasAccess('admin') && showIdIfAdmin" class="text-sm">ID : {{ selectedItem.id }}</p>

        <!-- Data section -->
        <div class="mt-6">
            <!-- Data auto render from "dataRender" props -->
            <dl class="grid grid-cols-1 sm:grid-cols-2">
                <template v-for="displayed in dataRender">
                    <div v-if="displayCondition(displayed)" class="border-t border-gray-200 p-4 sm:px-0">
                        <dt>{{ displayed.name }}</dt>
                        <dd>
                            <Link
                                v-if="displayCondition(displayed.link) && getValue(displayed.link.pathKey, true)"
                                :href="route(displayed.link.path, getValue(displayed.link.pathKey, true))"
                                class="hover:text-dogger-orange-400 underline"
                            >
                                {{ getValue(displayed.key, false, displayed.format) }}
                            </Link>
                            <template v-else>
                                {{ getValue(displayed.key, false, displayed.format) }}
                            </template>
                        </dd>
                    </div>
                </template>
            </dl>
            <!-- Data manual render from "slot" -->
            <div v-if="slots.default" class="border-t border-gray-200 w-full p-4 sm:px-0">
                <slot :item="selectedItem" />
            </div>
        </div>
    </div>
    <div class="masker" />
</template>

<style lang="scss" scoped>
.card.modal {
    @apply absolute top-16 left-1/2 -translate-x-1/2 z-20 overflow-y-auto;
    max-height: calc(100vh - 128px);
    width: 90%;

    @screen lg {
        @apply relative top-0 left-0 translate-x-0 z-[1] w-2/3;
        max-height: none;
    }

    dt, :slotted(dt) {
        @apply text-sm font-semibold text-gray-900;
    }

    dd, :slotted(dd) {
        @apply sm:mt-1 text-sm text-gray-700 truncate;
    }
}

.masker {
    @apply block lg:hidden fixed inset-0 w-full h-full bg-black opacity-50 z-10;
}
</style>