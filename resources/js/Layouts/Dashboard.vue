<script setup>
import { computed, onMounted, watch } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';
import { useToast } from 'vue-toastification';
// import NavBar from '@/Components/Navbar.vue';
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
        <!-- <NavBar /> -->

        <!-- Page Content -->
        <main class="p-4 md:p-6 lg:p-8 max-w-6xl mx-auto">
            <slot />
        </main>
    </div>
    <Footer />
</template>