<script setup>
import { Head } from '@inertiajs/vue3';

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

    <!-- Page Content -->
    <main class="flex justify-center items-center min-h-screen p-4">
        <slot />
    </main>
</template>
