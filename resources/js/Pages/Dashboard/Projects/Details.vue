<script setup>
import { useI18n } from 'vue-i18n';
import DashboardLayout from '@/Layouts/Dashboard.vue';
import LinedTitle from '@/Components/LinedTitle.vue';
import TabbedCard from '@/Components/Items/TabbedCard.vue';
import TabDetails from '@/Pages/Dashboard/Projects/Partials/TabDetails.vue';
import TabIssues from '@/Pages/Dashboard/Projects/Partials/TabIssues.vue';
import TabUsers from '@/Pages/Dashboard/Projects/Partials/TabUsers.vue';

const { t } = useI18n();

defineProps({
    project: {
        type: Object,
        required: true,
    },
    assignableUsers: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <DashboardLayout>
        <LinedTitle :title="project.name" />

        <TabbedCard class="mt-6 sm:mt-10">
            <div :title="t('companies.details')">
                <TabDetails :project="project" />
            </div>
            <div :title="t('projects.issues')">
                <TabIssues :issues="project.issues" />
            </div>
            <div :title="t('projects.assigned_user')">
                <TabUsers
                    :users="project.users"
                    :assignable-users="assignableUsers"
                    :project="project"
                />
            </div>
        </TabbedCard>
    </DashboardLayout>
</template>
