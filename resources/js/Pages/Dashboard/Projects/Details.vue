<script setup>
import DashboardLayout from '@/Layouts/Dashboard.vue';
import LinedTitle from '@/Components/LinedTitle.vue';
import TabbedCard from '@/Components/Items/TabbedCard.vue';
import TabDetails from '@/Pages/Dashboard/Projects/Partials/TabDetails.vue';
import TabIssues from '@/Pages/Dashboard/Projects/Partials/TabIssues.vue';
import TabUsers from '@/Components/Tabs/TabUsers.vue';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

defineProps({
    project: {
        type: Object,
        required: true,
    }
});
</script>

<template>
    <DashboardLayout>
        <LinedTitle :title="project.name" />

        <TabbedCard class="mt-6 sm:mt-10">
            <div :title="t('companies.details')">
                <TabDetails :project="project" />
            </div>
            <div :title="t('companies.issues')">
                <TabIssues :issues="project.issues" />
            </div>
            <div :title="t('companies.users')">
                <TabUsers :users="project.users" />
            </div>
        </TabbedCard>
    </DashboardLayout>
</template>
