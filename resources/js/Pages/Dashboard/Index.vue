<script setup>
import { ref, computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import { useI18n } from "vue-i18n";
import {
    ArrowPathIcon,
    RectangleStackIcon,
    ExclamationTriangleIcon,
    BuildingOffice2Icon,
    ChartBarIcon
} from '@heroicons/vue/24/outline';
import DashboardLayout from '@/Layouts/Dashboard.vue';
import SelectWrapper from '@/Components/Form/SelectWrapper.vue';
import CountCard from '@/Components/Stats/CountCard.vue';
import LineChart from '@/Components/Stats/LineChart.vue';
import LinedTitle from '@/Components/LinedTitle.vue';

const { t } = useI18n({});

const props = defineProps({
    cards: {
        type: Object,
        required: true
    },
    chart : {
        type: Object,
        required: true
    }
});

const selectedCompany = ref(null);

const selectOpts = computed(() => {
    const companyArray = Object.entries(props.chart.companies).map(([id, company]) => ({
        name: company.name,
        id: id
    }));

    return [{ name: t('dashboard.company_filter_all'), id: null }, ...companyArray];
});

const chartDataFormated = computed(() => {
    if (selectedCompany.value === null) {
        return props.chart.total;
    }

    return props.chart.companies[selectedCompany.value].projects;
});
</script>

<template>
    <DashboardLayout>
        <LinedTitle :title="t('dashboard.title')">
            <Link :href="route('dashboard.cache.clear')" class="btn generic sm">
                {{ $t('dashboard.refresh') }}
                <ArrowPathIcon class="h-5 w-5" />
            </Link>
        </LinedTitle>

        <section class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mt-6 sm:mt-10">
            <CountCard
                :title="t('dashboard.companies_count')"
                :value="cards.companies"
                :icon="BuildingOffice2Icon"
                icon-bg="bg-green-600"
                route-name="dashboard.companies.list"
            />
            <CountCard
                :title="t('dashboard.projects_count')"
                :value="cards.projects"
                :icon="RectangleStackIcon"
                icon-bg="bg-blue-500"
                route-name="dashboard.projects.list"
            />
            <CountCard
                :title="t('dashboard.issues_count')"
                :value="cards.issues"
                :icon="ExclamationTriangleIcon"
                icon-bg="bg-red-500"
                route-name="dashboard.issues.list"
            />
            <CountCard
                :title="t('dashboard.last24h_issues_count')"
                :value="cards.issues24.count"
                :percentage="cards.issues24.percentage"
                :icon="ChartBarIcon"
                route-name="dashboard.issues.list"
            />
        </section>

        <section class="mt-6 sm:mt-8">
            <SelectWrapper
                v-model="selectedCompany"
                :options="selectOpts"
                :title="t('dashboard.company_filter_select')"
                reduce="id"
                class="max-w-xs"
            />
            <LineChart
                :chart-data="chartDataFormated"
                :is-multi="selectedCompany !== null"
                class="mt-2"
            />
        </section>
    </DashboardLayout>
</template>

<style lang="scss" scoped></style>
