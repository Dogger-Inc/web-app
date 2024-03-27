<script setup >
import { usePage } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';

const user = usePage().props.auth.user;
const initialsLetter = ref('');

const extractFirstLetter = (firstName, lastName) => {
    return firstName.charAt(0).toUpperCase() + lastName.charAt(0).toUpperCase();;
}

onMounted(() => {
    initialsLetter.value = extractFirstLetter(user.firstname, user.lastname);
})
</script>

<template>
    <div class="rounded-full bg-dogger-orange-600 p-2 text-white font-bold flex items-center justify-center">
        {{ initialsLetter }}
    </div>
</template>