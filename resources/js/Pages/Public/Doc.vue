<script setup>
import { ref, onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/Public.vue';

const content = ref('');
const VueMarkdown = ref(null);
const lang = usePage().props.locale;

const link = `/docs/doc-${lang}.md`;

// dynamically import the VueMarkdown only in client-side
onMounted(async () => {
    if (typeof window !== "undefined") {
        VueMarkdown.value = (await import('vue-markdown-render')).default;
    }
});

onMounted(() => {
    fetch(link).then(response => response.text()).then(text => {
        content.value = text;
    });
});
</script>

<template>
    <PublicLayout>
        <div v-if="VueMarkdown" class="md">
            <vue-markdown :source="content"></vue-markdown>
        </div>
    </PublicLayout>
</template>

<style lang="scss" scoped>
.md {
    border-radius: 10px;
    padding-inline: 2rem;

    :deep(*) {
        h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        h2 {
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        h3 {
            font-size: 1rem;
            margin-bottom: 1rem;
        }

        code {
            background-color: #f4f4f4;
            padding: 0.2rem 0.4rem;
            border-radius: 0.3rem;
        }

        p {
            margin-bottom: 1rem;
            font-size: 1rem;
        }

        a {
            color: #f04706;
        }
    }        
}
</style>
