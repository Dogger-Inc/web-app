<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

const props = defineProps({
    user: Object,
});

const user = usePage().props.auth.user;

const initialsLetter = computed(() => {
    if (props.user) {
        return props.user.firstname.charAt(0).toUpperCase() + props.user.lastname.charAt(0).toUpperCase();
    } else {
        return user.firstname.charAt(0).toUpperCase() + user.lastname.charAt(0).toUpperCase();ß
    }
});
</script>
<template>
    <div class="flex items-center justify-center w-10 h-10 p-2 font-bold text-white rounded-full bg-dogger-orange-600 whitespace-nowrap"> {{ initialsLetter }} </div>
</template>