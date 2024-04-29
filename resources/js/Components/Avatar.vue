<script setup >
import { usePage } from '@inertiajs/vue3';
import {computed } from 'vue';

const user = usePage().props.auth.user;
const initialsLetter = computed (() => {
    return user.firstname.charAt(0).toUpperCase() + user.lastname.charAt(0).toUpperCase();
})
</script>

<template>
    <div class="h-12 w-12 rounded-full bg-dogger-orange-600 p-2 text-white font-bold flex items-center justify-center">
        {{ initialsLetter }}
    </div>
</template>