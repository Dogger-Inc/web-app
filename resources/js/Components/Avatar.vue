<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

const props = defineProps({
    user: Object,
});

const pageUser = usePage().props.auth.user;

const initialsLetter = computed(() => {
    const user = props.user || pageUser;
    return user.firstname.charAt(0).toUpperCase() + user.lastname.charAt(0).toUpperCase();
});
</script>
<template>
    <div class="flex items-center justify-center w-10 h-10 p-2 font-bold text-white rounded-full bg-dogger-orange-600 whitespace-nowrap"> {{ initialsLetter }} </div>
</template>