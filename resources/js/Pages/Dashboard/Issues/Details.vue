<script setup>
import DashboardLayout from '@/Layouts/Dashboard.vue';
import LinedTitle from '@/Components/LinedTitle.vue';
import Badge from '@/Components/Badge.vue';
import Stacktrace from '@/Components/Stacktrace.vue';
import List from '@/Components/Items/List.vue';
import { useI18n } from 'vue-i18n';
import { Link } from '@inertiajs/vue3';

defineProps({
    issue: {
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
        <LinedTitle :title="issue.message" truncate>
            <Link href="/issues" class="btn primary sm">{{ t('issues.back') }}</Link>
        </LinedTitle>

        <div class="mt-12">
            <div class="space-y-2">
                <span class="font-semibold">{{t('issues.complete_name')}}</span>
                <div class="flex flex-row gap-2 items-center">
                    {{issue.message}}
                </div>
            </div>
        </div>

        <div class="mt-6 grid grid-cols-12 gap-6">
            <div class="flex flex-col gap-6 col-span-8">
                <div class="space-y-2">
                    <span class="font-semibold">{{t('issues.stacktrace')}}</span>
                    <div class="flex flex-row gap-2 items-center">
                        <Stacktrace :text="issue.stacktrace" />
                    </div>
                </div>

                <div class="space-y-2">
                    <span class="font-semibold">{{t('issues.comments')}}</span>

                    <List
                        :data="issue.comments"
                        :searchbar="false"
                        placeholder="t('issues.no_comment')"
                    />
                </div>
            </div>

            <div class="col-span-4 flex flex-col gap-10">
                <div class="space-y-2">
                    <span class="font-semibold">{{t('issues.tags')}}</span>
                    <div class="flex flex-row gap-2 items-center">
                        <Badge v-if="issue.env" :title="issue.env" />
                        <Badge v-if="issue.http_code" :title="`${issue.http_code}`" />
                        <Badge v-if="issue.type" :title="issue.type" />
                        <Badge v-if="issue.status" :title="issue.status" />
                    </div>
                </div>

                <div class="space-y-2">
                    <span class="font-semibold">{{t('issues.assigned_user')}}s</span>
                    <div class="flex flex-col gap-2">
                        <span v-for="user in issue.users" :key="user.id" class="border p-2 text-sm rounded">
                            {{ user.fullname }} ({{ user.email }})
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </DashboardLayout>
</template>
