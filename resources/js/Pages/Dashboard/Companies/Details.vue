<script setup>
import DashboardLayout from '@/Layouts/Dashboard.vue';
import LinedTitle from '@/Components/LinedTitle.vue';
import TabbedCard from '@/Components/Items/TabbedCard.vue';
import TabDetails from '@/Pages/Dashboard/Companies/Partials/TabDetails.vue';
import TabProjects from '@/Pages/Dashboard/Companies/Partials/TabProjects.vue';
import TabUsersPending from '@/Pages/Dashboard/Companies/Partials/TabUsersPending.vue';
import TabUsers from '@/Components/Tabs/TabUsers.vue';

defineProps({
    company: {
        type: Object,
        required: true,
    }
});
</script>

<template>
    <DashboardLayout>
        <LinedTitle :title="company.name" />

        <TabbedCard class="mt-6 sm:mt-10">
            <div :title="t('companies.details')">
                <TabDetails :company="company" />
            </div>
            <div :title="t('companies.projects')">
                <TabProjects :projects="company.projects" />
            </div>
            <div title="Utilisateur(s) actif(s)">
                <TabUsers :users="company.activeUsers" :company="company.id" />
            </div>
            <div title="En attente (inactif)">
                <TabUsersPending :users="company.inactiveUsers" :company="company.id" />
            </div>
        </TabbedCard>
    </DashboardLayout>
</template>
