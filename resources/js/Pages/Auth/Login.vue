<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import InputWrapper from '@/Components/Form/InputWrapper.vue';
import AuthLayout from '@/Layouts/Auth.vue';

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submitForm = () => {
    form.post(route('login.post'), { onStart: () => form.clearErrors() });
};
</script>

<template>
    <AuthLayout>
        <template v-slot:header>
            <h2 class="mt-6 text-center text-2xl md:text-3xl font-bold tracking-tight text-gray-900">
                Sign in to your account
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Or
                <Link :href="route('register')" class="font-medium text-dogger-orange-400 hover:text-dogger-orange-500">
                    create a new account
                </Link>
            </p>
        </template>

        <form @submit.prevent="submitForm" class="flex flex-col gap-5 lg:gap-6">
            <InputWrapper
                v-model="form.email"
                :error="form.errors.email"
                title="Email"
                type="email"
            />
            <InputWrapper
                v-model="form.password"
                :error="form.errors.email"
                title="Password"
                type="password"
            />

            <div class="flex flex-col sm:flex-row gap-2 sm:justify-between sm:items-center -mt-4">
                <label class="flex items-center" for="remember">
                    <input
                        v-model="form.remember"
                        type="checkbox"
                        id="remember"
                        class="rounded border-gray-300 focus:ring-dogger-orange-500"
                    />
                    <span class="ml-2 text-gray-500">Remember me</span>
                </label>

                <Link :href="route('password.request')" class="text-gray-500 hover:text-dogger-orange-500">
                    Mot de passe oublié ?
                </Link>
            </div>
            
            <button class="btn primary mt-6 !w-full" type="submit">
                Login
            </button>
        </form>
    </AuthLayout>
</template>