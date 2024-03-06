<script setup>
import DashboardLayout from '@/Layouts/Dashboard.vue';
import LinedTitle from '@/Components/LinedTitle.vue';
import Badge from '@/Components/Badge.vue';
import Stacktrace from '@/Components/Stacktrace.vue';
import List from '../../../Components/Items/List.vue';

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
</script>

<template>
    <DashboardLayout>
        <LinedTitle :title="issue.message" />

        <div class="mt-12 grid grid-cols-12 gap-6">
            <div class="flex flex-col gap-6 col-span-8">
                <div class="space-y-2">
                    <span class="font-semibold">Stacktrace</span>
                    <div class="flex flex-row gap-2 items-center">
                        <Stacktrace :text="issue.stacktrace" />
                    </div>
                </div>

                <div class="space-y-2">
                    <span class="font-semibold">Comments</span>

                    <List
                        :data="issue.comments"
                        :searchbar="false"
                        placeholder="Aucun commentaire"
                    />
                </div>
            </div>

            <div class="col-span-4 flex flex-col gap-10">
                <div class="space-y-2">
                    <span class="font-semibold">Tags</span>
                    <div class="flex flex-row gap-2 items-center">
                        <Badge :title="issue.env" />
                        <Badge :title="`${issue.http_code}`" />
                        <Badge :title="issue.type" />
                        <Badge :title="issue.status" />
                    </div>
                </div>

                <div class="space-y-2">
                    <span class="font-semibold">Assigned users</span>
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
