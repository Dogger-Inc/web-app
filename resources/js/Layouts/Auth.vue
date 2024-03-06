<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Logo from '@assets/images/logo.png';

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
        <div class="max-w-md w-full mb-14 flex flex-col gap-6 md:gap-12">
            <div>
                <Link :href="route('homepage')">
                    <img :src="Logo" alt="Logo Dogger" class="mx-auto w-24" />
                </Link>
                <slot name="header" />
            </div>
            <slot />
        </div>
    </main>
</template>
