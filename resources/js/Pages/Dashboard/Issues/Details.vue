<script setup>
import dayjs from 'dayjs';
import { useI18n } from 'vue-i18n';
import { Link, router } from '@inertiajs/vue3';
import { XMarkIcon } from '@heroicons/vue/24/solid';
import DashboardLayout from '@/Layouts/Dashboard.vue';
import LinedTitle from '@/Components/LinedTitle.vue';
import Stacktrace from '@/Components/Stacktrace.vue';
import CommentsThread from '@/Components/CommentsThread.vue';
import ProjectUsersSearch from '@/Components/Form/ProjectUsersSearch.vue';
import Badge from '@/Components/Badge.vue';

const { t } = useI18n();

const props = defineProps({
    issue: {
        type: Object,
        required: true,
    },
    currentUser: {
        type: Object,
        required: true,
    }
});

const statusEnum = {
    new: t('issues.new'),
    pending: t('issues.pending'),
    in_progress: t('issues.in_progress'),
    resolved: t('issues.resolved'),
};

function handleAssignUser(user) {
    router.post(
        route('dashboard.issues.assignUser.post', props.issue.id),
        { user_id: user.id },
        { preserveState: false, preserveScroll: true }
    );
}

function handleUnassignUser(user) {
    router.post(
        route('dashboard.issues.unassignUser.post', props.issue.id),
        { user_id: user.id },
        { preserveState: false, preserveScroll: true }
    );
}

function handleStatusChange() {
    router.post(
        route('dashboard.issues.changeStatus.post', props.issue.id),
        { status: props.issue.status },
        { preserveState: false, preserveScroll: true }
    );
}

</script>
<template>
    <DashboardLayout>
        <LinedTitle :title="issue.message" truncate>
            <Link :href="route('dashboard.issues.list')" class="btn primary sm">
                {{ t('issues.back') }}
            </Link>
        </LinedTitle>
        <div class="mt-12">
            <div class="space-y-2">
                <span class="font-semibold">{{ t('issues.complete_name') }}</span>
                <div class="flex flex-row items-center gap-2"> {{ issue.message }} </div>
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mt-6">
            <div class="flex flex-col sm:col-span-2 gap-6">
                <div class="space-y-2">
                    <span class="font-semibold">{{ t('issues.stacktrace') }}</span>
                    <div class="flex flex-row items-center gap-2">
                        <Stacktrace :text="issue.stacktrace" />
                    </div>
                </div>
                <div class="space-y-2">
                    <span class="font-semibold">{{ t('issues.comments') }}</span>
                    <CommentsThread
                        :comments="issue.comments"
                        :commentableId="props.issue?.id"
                        addPath="dashboard.issues.addComment.post"
                    />
                </div>
            </div>
            <div class="flex flex-col col-span-1 gap-10">
                <div class="space-y-2">
                    <span class="font-semibold">{{ t('issues.tags') }}</span>
                    <div class="flex flex-row items-center gap-2">
                        <Badge v-if="issue.env" :title="issue.env" />
                        <Badge v-if="issue.http_code" :title="`${issue.http_code}`" />
                        <Badge v-if="issue.type" :title="issue.type" />
                        <Badge v-if="issue.status" :title="issue.status" />
                    </div>
                </div>
                <div class="space-y-2">
                    <span class="font-semibold">{{ t('issues.triggered_at') }}</span>
                    <div class="flex flex-col gap-2">
                        <span>{{ dayjs(issue.triggered_at).format('DD/MM/YYYY HH:mm:ss') }}</span>
                    </div>
                </div>
                <div class="space-y-2">
                    <span class="font-semibold">{{ t('projects.name') }}</span>
                    <div class="flex flex-col gap-2">
                        <Link
                            :href="route('dashboard.projects.details', issue.project.id)"
                            class="hover:text-dogger-orange-400"
                        >
                            {{ issue.project.name }}
                        </Link>
                    </div>
                </div>
                <div v-if="currentUser.canUpdate" class="space-y-2">
                    <span class="font-semibold">{{ t('issues.status') }}</span>
                    <select
                        v-model="issue.status"
                        @change="handleStatusChange"
                        class="w-full p-2 border rounded"
                    >
                        <option
                            v-for="(value, key) in statusEnum"
                            :key="key"
                            :value="key"
                        >
                            {{ value }}
                        </option>
                    </select>
                </div>
                <div v-if="currentUser.canUpdate" class="space-y-2">
                    <span class="font-semibold">{{ t('issues.assigned_user') }}</span>
                    <ProjectUsersSearch @select="handleAssignUser" :project-id="issue.project_id" />
                    <div class="flex flex-col gap-2">
                        <div
                            v-for="user in issue.users"
                            :key="user.id"
                            class="flex flex-row items-center justify-between p-2 text-sm border rounded"
                        >
                            <span>{{ user.fullname }} ({{ user.email }})</span>
                            <button
                                @click="() => handleUnassignUser(user)"
                                class="bg-red-400 text-white rounded p-0.5"
                            >
                                <XMarkIcon class="w-4 h-4" />
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </DashboardLayout>
</template>