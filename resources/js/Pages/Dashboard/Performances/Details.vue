<script setup>
import DashboardLayout from '@/Layouts/Dashboard.vue';
import LinedTitle from '@/Components/LinedTitle.vue';
import Badge from '@/Components/Badge.vue';
import CommentsThread from '@/Components/CommentsThread.vue';
import dayjs from 'dayjs';
import { useI18n } from 'vue-i18n';
import { Link } from '@inertiajs/vue3';

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

                    <div class="flex flex-col gap-2">
                        <div
                            v-for="performance in performances"
                            :key="performance.id"
                            class="flex flex-row items-center justify-between text-sm"
                        >
                            <span>{{ dayjs(performance.created_at).format('DD/MM/YYYY HH:mm:ss') }}</span>
                            <span class="text-dogger-orange-400 font-semibold">{{ performance.duration / 1000 }}s</span>
                        </div>
                    </div>
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
                    <span class="font-semibold">{{t('performances.assigned_user')}}s</span>
                    <div class="flex flex-col gap-2">
                        <span v-for="user in group.users" :key="user.id" class="border p-2 text-sm rounded">
                            {{ user.fullname }} ({{ user.email }})
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </DashboardLayout>
</template>
