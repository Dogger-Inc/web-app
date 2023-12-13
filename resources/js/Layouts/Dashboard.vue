<script setup>
import { computed, onMounted, watch } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';
import { useToast } from 'vue-toastification';
import NavBar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';

const meta = {
    title: 'Dogger',
    description: ''
}

const toast = useToast();
const toastProps = computed(() => usePage().props.toast);

watch(toastProps, () => {
    setToast();
});

onMounted(() => {
    setToast();
});

const setToast = () => {
    if (toastProps.value) {
        // Available types: "success", "error", "default", "info" and "warning"
        toast[toastProps.value.type](toastProps.value.message);
    }
}
</script>

<template>
    <Head>
        <!-- Dynamic meta default value -->
        <title>{{ meta.title }}</title>
        <meta head-key="description" name="description" :content="meta.description">
        <meta head-key="ogTitle" property="og:title" :content="meta.title">
        <meta head-key="ogDescription" property="og:description" :content="meta.description">
        <meta head-key="twitterTitle" name="twitter:title" :content="meta.title">
        <meta head-key="twitterDescription" name="twitter:description" :content="meta.description">
    </Head>

    <div class="min-h-screen">
        <NavBar />

        <!-- Page Content -->
        <main class="px-4 py-2 md:px-6 md:py-3 lg:px-8 lg:py-4 max-w-6xl mx-auto">
            <slot />
        </main>
    </div>
    <Footer />
</template>