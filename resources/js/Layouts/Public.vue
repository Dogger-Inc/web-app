<script setup>
import { Head } from '@inertiajs/vue3';
// import NavBar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';

const meta = {
    title: 'Dogger',
    description: ''
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