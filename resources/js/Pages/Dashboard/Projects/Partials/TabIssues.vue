<script setup>
import { useI18n } from 'vue-i18n';
import { useToast } from 'vue-toastification';
import ItemsList from '@/Components/Items/List.vue';

const { t } = useI18n({});
const toast = useToast();

defineProps({
    issues: {
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
        :data="issues"
        :searchbar="false"
        v-slot="item"
    >
        <div>
            <span class="text-dogger-orange-500">{{ item.http_code }}</span>
            <p class="text-sm md:text-base font-semibold">{{ item.message }}</p>
        </div>
    </ItemsList>
</template>
