<script setup>
import { ref, computed } from 'vue';
import { Line } from 'vue-chartjs';
import {
    Chart as ChartJS,
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Tooltip,
    Legend,
    Colors
} from 'chart.js';

ChartJS.register(
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Tooltip,
    Legend,
    Colors
);

const props = defineProps({
    chartData: {
        type: Object,
        required: true
    },
    label: {
        type: String,
        required: true
    },
    isMulti: {
        type: Boolean,
        default: false
    }
});

const chartRef = ref(null);

const data = computed(() => {
    if (props.isMulti) {
        return Object.keys(props.chartData).map((key) => ({
            label: key,
            cubicInterpolationMode: 'monotone',
            data: props.chartData[key]
        }));
    }

    return [{
        label: props.label,
        borderColor: '#ff8437',
        cubicInterpolationMode: 'monotone',
        data: props.chartData
    }];
});

const options = computed(() => ({
    scales: {
        y: { type: 'linear', grace: '5%', beginAtZero: true },
        x: { type: 'category' },
    },
    scale: {
        ticks: { precision: 0 }
    },
    plugins: {
        legend: {
            display: props.isMulti,
            position: 'bottom'
        },
        colors: {
            enabled: props.isMulti
        }
    }
}));

</script>

<template>
    <Line
        ref="chartRef"
        :data="{ datasets: data }"
        :options="options"
        class="py-3"
    />
</template>
