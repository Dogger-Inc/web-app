<script setup>
import { ref, useSlots, onMounted, watch } from 'vue';
import { usePage, router } from '@inertiajs/vue3';

const slots = useSlots();
const tabs = ref([]);
const currentRoutePath = usePage().props.route.path;
const tabParam = usePage().props.route.query?.tab;

onMounted(() => {
    const tmp = [];

    slots.default().forEach((tab, index) => {
        console.log(tab);

        tmp.push({
            id: index,
            title: tab.props.title,
            content: tab.children,
            current: tabParam ? index === tabParam : index === 0,
        });
    });

    tabs.value = tmp;
});

watch(() => tabParam, (val) => {
    if(!val || tabs.length === 0) return;

    const tabId = parseInt(val);
    // if current tab id is the same as the one in the url, we don't need to do anything
    if(tabs.find((tab) => tab.current).id === tabId) return;

    tabs.value.forEach((tab) => {
        tab.current = tab.id === tabId;
    });
});

const setActiveTab = (id) => {
    router.get(currentRoutePath, { tab: id }, {
        preserveScroll: true,
        preserveState: true,
    });
}
</script>

<template>
    <div v-if="tabs.length > 0" class="card !p-0">
        <section v-if="tabs.length > 1">
            <!-- Mobile -->
            <div class="sm:hidden">
                <label htmlFor="nav-tabs" class="sr-only">
                    Select a tab
                </label>
                <select
                    id="nav-tabs"
                    name="nav-tabs"
                    class="block w-full rounded-t-lg border-b border-gray-300 p-2"
                    :value="tabs.find((tab) => tab.current).id"
                    @change="setActiveTab($event.target.value)"
                >
                    <option v-for="tab in tabs" :key="tab.id" :value="tab.id">
                        {{tab.title}}
                    </option>
                </select>
            </div>
            <!-- Tablet and Desktop -->
            <div class="hidden sm:block">
                <nav class="isolate flex divide-x divide-gray-200 rounded-t-lg shadow overflow-x-auto" aria-label="Tabs">
                    <button
                        v-for="(tab, tabIdx) in tabs"
                        :key="tab.id"
                        @click="setActiveTab(tab.id)"
                        class="relative flex-1 whitespace-nowrap p-4 text-center text-sm font-medium hover:bg-gray-50"
                        :class="[
                            tab.current ? ' text-gray-900' : ' text-gray-500 hover:text-gray-700',
                            { 'rounded-tl-lg': tabIdx === 0 },
                            { 'rounded-tr-lg': tabIdx === tabs.length - 1 },
                        ]"
                    >
                        <span>{{tab.title}}</span>
                        <span
                            aria-hidden="true"
                            class="absolute inset-x-0 bottom-0 h-0.5"
                            :class="tab.current ? 'bg-dogger-orange-500' : 'bg-transparent'"
                        />
                    </button>
                </nav>
            </div>
        </section>

        <!-- Display tab content -->
        <div class="p-4">
            {{ tabs.find((tab) => tab.current).content }}
        </div>
    </div>
</template>