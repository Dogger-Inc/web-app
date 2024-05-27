<script setup>
import { XMarkIcon } from '@heroicons/vue/24/solid';
import DashboardLayout from '@/Layouts/Dashboard.vue';
import LinedTitle from '@/Components/LinedTitle.vue';
import Badge from '@/Components/Badge.vue';
import CommentsThread from '@/Components/CommentsThread.vue';
import dayjs from 'dayjs';
import { useI18n } from 'vue-i18n';
import UsersSearch from '@/Components/Form/UsersSearch.vue';
import { Link, router } from '@inertiajs/vue3';
import LineChart from '@/Components/Stats/LineChart.vue';
import { computed } from 'vue';

const props = defineProps({
    group: {
        type: Object,
        required: true,
    },
    performances: {
        type: Object,
        required: true,
    },
    currentUser: {
        type: Object,
        required: true,
    }
});

const { t } = useI18n();

const performanceData = computed(() => props.performances.reduce((acc, performance) => ({
    ...acc,
    [dayjs(performance.created_at).format('DD/MM/YY HH:mm:ss')]: performance.duration / 1000
}), {}));

function handleAssignUser(user) {
    router.post(
        route('dashboard.performances.assignUser.post', props.group.id),
        { user_id: user.id },
        {},
        { preserveState: false, preserveScroll: true }
    );
}

function handleUnassignUser(user) {
    router.post(
        route('dashboard.performances.unassignUser.post', props.group.id),
        { user_id: user.id },
        {},
        { preserveState: false, preserveScroll: true }
    );
}
</script>

<template>
    <DashboardLayout>
        <LinedTitle :title="`Performance issue : ${group.key}`" truncate>
            <Link href="/performances" class="btn primary sm">{{ t('performances.back') }}</Link>
        </LinedTitle>

        <div class="mt-12">
            <div class="space-y-2">
                <span class="font-semibold">{{t('performances.complete_name')}}</span>
                <div class="flex flex-row gap-2 items-center">
                    {{group.key}}
                </div>
            </div>
        </div>

        <div class="mt-6 grid grid-cols-12 gap-6">
            <div class="flex flex-col gap-6 col-span-8">
                <div class="space-y-2">
                    <span class="font-semibold">{{t('performances.values')}}</span>

                    <LineChart
                        :chart-data="performanceData"
                        label="Temps (sec)"
                        class="mt-2"
                    />
                </div>

                <div class="space-y-2">
                    <span class="font-semibold">{{t('performances.comments')}}</span>

                    <CommentsThread
                        :comments="group.comments"
                        :commentableId="props.group?.id"
                        addPath="dashboard.performances.addComment.post"
                    />
                </div>
            </div>

            <div class="col-span-4 flex flex-col gap-10">
                <div class="space-y-2">
                    <span class="font-semibold">{{t('performances.tags')}}</span>
                    <div class="flex flex-row gap-2 items-center">
                        <Badge v-if="group.env" :title="group.env" />
                    </div>
                </div>

                <div class="space-y-2">
                    <span class="font-semibold">{{t('performances.assigned_user')}}</span>
                    <UsersSearch @select="handleAssignUser" />
                    <div class="flex flex-col gap-2">
                        <div
                            v-for="user in group.users"
                            :key="user.id"
                            class="border p-2 text-sm rounded flex flex-row items-center justify-between"
                        >
                            <span>{{ user.fullname }} ({{ user.email }})</span>
                            <button
                                class="bg-red-400 text-white rounded p-0.5"
                                @click="() => handleUnassignUser(user)"
                            >
                                <XMarkIcon class="h-4 w-4" />
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </DashboardLayout>
</template>
