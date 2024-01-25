<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';

const { t } = useI18n({});

const props = defineProps({
    title: {
        type: String,
        required: true
    },
    value: {
        type: [String, Number, Boolean],
        default: null
    },
    spacer: {
        type: Boolean,
        default: true
    },
    format: Function,
    // { path: 'path', param: 1, <optional>type: 'internal'|'external' }
    linkOpts: Object
});

const isLinkable = computed(() => {
    return props.linkOpts && props.linkOpts.path && props.linkOpts.param;
});

const formatedValue = computed(() => {
    if(props.format && (props.value !== undefined && props.value !== null)) {
        return props.format(props.value);
    }
    return props.value ?? t("no_value");
});

const getLinkHref = () => {
    if(!isLinkable.value) return null;
    if(props.linkOpts.type === 'external') return props.linkOpts.path + props.linkOpts.param;
    return route(props.linkOpts.path, props.linkOpts.param);
}
</script>

<template>
    <div class="p-4 sm:px-0" :class="{'border-t border-gray-200': spacer}">
        <dt class="text-sm font-medium text-gray-900">
            {{ title }}
        </dt>
        <dd class="sm:mt-1 text-sm text-gray-700 whitespace-pre-wrap">
            <template v-if="isLinkable">
                <a
                    v-if="linkOpts.type === 'external'"
                    :href="getLinkHref()"
                    target="_blank"
                    rel="noopener"
                >
                    {{ formatedValue }}
                </a>
                <Link v-else :href="getLinkHref()">
                    {{ formatedValue }}
                </Link>
            </template>
            <template v-else>
                {{ formatedValue }}
            </template>
        </dd>
    </div>
</template>

<style lang="scss" scoped>
a {
    @apply underline hover:text-dogger-orange-500;
}
</style>