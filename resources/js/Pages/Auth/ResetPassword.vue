<script setup>
import { useForm } from '@inertiajs/vue3';
import InputWrapper from '@/Components/Form/InputWrapper.vue';
import AuthLayout from '@/Layouts/Auth.vue';

const props = defineProps({
    token: {
        type: String,
        required: true,
    },
    email: {
        type: String,
        required: true,
    },
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.update'), {
        onStart: () => form.clearErrors(),
    });
};
</script>

<template>
    <AuthLayout>
        <template v-slot:header>
            <h2 class="mt-6 text-center text-2xl md:text-3xl font-bold tracking-tight text-gray-900">
                Mot de passe oublié ?
            </h2>
        </template>

        <form @submit.prevent="submit" class="flex flex-col gap-5 lg:gap-6">
            <InputWrapper
                v-model="form.email"
                :error="form.errors.email"
                title="Email"
                type="email"
            />
            <div class="grid grid-cols-1 md:grid-cols-2 md:gap-5">
                <InputWrapper
                    v-model="form.password"
                    :error="form.errors.password"
                    title="Password" type="password"
                />
                <InputWrapper
                    v-model="form.password_confirmation"
                    :error="form.errors.password_confirmation"
                    title="Confirm Password" type="password"
                />
            </div>

            <button type="submit" :disabled="form.processing" class="btn primary !w-full mt-5 ">
                Enregistrer le nouveau mot de passe
            </button>
        </form>
    </AuthLayout>
</template>
