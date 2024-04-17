<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import InputWrapper from '@/Components/Form/InputWrapper.vue';
import AuthLayout from '@/Layouts/Auth.vue';
import { useI18n } from "vue-i18n"; 

const { t } = useI18n({});

const form = useForm({
    firstname: '',
    lastname: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submitForm = () => {
    form.post(route('register.post'), { onStart: ()=> form.clearErrors() });
};
</script>

<template>
    <AuthLayout>
        <template v-slot:header>
            <h2 class="mt-6 text-center text-2xl md:text-3xl font-bold tracking-tight text-gray-900">
                {{ $t('register.title')}}
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                {{$t('or')}}
                <Link :href="route('login')" class="font-medium text-dogger-orange-400 hover:text-dogger-orange-500">
                   {{($t('signin')).toLowerCase()}}
                </Link>
            </p>
        </template>

        <form @submit.prevent="submitForm" class="flex flex-col gap-5 lg:gap-6">
            <div class="grid grid-cols-1 md:grid-cols-2 md:gap-5">
                <InputWrapper v-model="form.firstname" :error="form.errors.firstname" :title="$t('firstname')" />
                <InputWrapper v-model="form.lastname" :error="form.errors.lastname" :title="$t('lastname')" />
            </div>
            <InputWrapper
                v-model="form.email"
                :error="form.errors.email"
                :title="$t('email')"
                type="email"
            />
            <div class="grid grid-cols-1 md:grid-cols-2 md:gap-5">
                <InputWrapper
                    v-model="form.password"
                    :error="form.errors.password"
                    :title="$t('password')" type="password"
                />
                <InputWrapper
                    v-model="form.password_confirmation"
                    :error="form.errors.password_confirmation"
                    :title="$t('confirm_password')" type="password"
                />
            </div>

            <button class="btn primary mt-6 !w-full" type="submit">
                {{ $t('signin') }}
            </button>
        </form>
    </AuthLayout>
</template>