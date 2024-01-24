<script setup>
import { useI18n } from 'vue-i18n';
import { useToast } from 'vue-toastification';
import ItemsList from '@/Components/Items/List.vue';

const { t } = useI18n({});
const toast = useToast();

defineProps({
    projects: {
        type: Object,
        required: true,
    },
});

const copyToClipboard = (text) => {
    navigator.clipboard.writeText(text);
    toast.success(t("copied"));
};
</script>

<template>
    <ItemsList
        :data="projects"
        :searchbar="false"
        v-slot="item"
    >
        <div>
            <p class="text-sm md:text-base font-semibold">{{ item.name }}</p> 
            <p
                @click.prevent="copyToClipboard(item.key)"
                class="text-xs md:text-sm font-medium text-gray-500"
            >
                {{ item.key }}
            </p>
        </div>
    </ItemsList>
</template>