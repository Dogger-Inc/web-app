<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import InputWrapper from '@/Components/Form/InputWrapper.vue';
import AuthLayout from '@/Layouts/Auth.vue';
import Logo from '@assets/images/logo.png';

const form = useForm({
    firstname: '',
    lastname: '',
    email: '',
    password: '',
    password_confirmation: '',
    organization_name: '',
});

const submitForm = () => {
    form.post(route('register.post'), { onStart: ()=> form.clearErrors() });
};
</script>

<template>
    <AuthLayout>
        <div class="max-w-md w-full mb-14 flex flex-col gap-6 md:gap-12">
            <div>
                <Link :href="route('homepage')">
                    <img :src="Logo" alt="Logo Dogger" class="mx-auto w-24" />
                </Link>
                <h2 class="mt-6 text-center text-2xl md:text-3xl font-bold tracking-tight text-gray-900">
                    Create your account
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    Or
                    <Link :href="route('login')" class="font-medium text-dogger-orange-400 hover:text-dogger-orange-500">
                        login
                    </Link>
                </p>
            </div>

            <form @submit.prevent="submitForm" class="flex flex-col gap-5 lg:gap-6">
                <div class="grid grid-cols-1 md:grid-cols-2 md:gap-5">
                    <InputWrapper v-model="form.firstname" :error="form.errors.firstname" title="First Name" />
                    <InputWrapper v-model="form.lastname" :error="form.errors.lastname" title="Last Name" />
                </div>
                <InputWrapper v-model="form.email" :error="form.errors.email" title="Email" type="email" />
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
                <InputWrapper
                    v-model="form.organization_name"
                    :error="form.errors.organization_name"
                    title="Organization name"
                />
                <button class="btn primary mt-6 !w-full" type="submit">Register</button>
            </form>
        </div>
    </AuthLayout>
</template>