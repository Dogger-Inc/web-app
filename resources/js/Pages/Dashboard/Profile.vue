<script setup>
import { useI18n } from 'vue-i18n';
import { useForm, usePage } from '@inertiajs/vue3';
import DashboardLayout from '@/Layouts/Dashboard.vue';
import InputWapper from '@/Components/Form/InputWrapper.vue';
import LinedTitle from '@/Components/LinedTitle.vue';

const { t } = useI18n({});
const user = usePage().props?.auth?.user;

const formEditProfile = useForm({
    firstname: user.firstname,
    lastname: user.lastname,
    email: user.email,
});

const formEditPassword = useForm({
    old_password: '',
    password: '',
    password_confirmation: '',
});

const editProfile = () => {
    formEditProfile.post(route('dashboard.profile.edit.post'), {
        onStart: () => formEditProfile.clearErrors(),
    });
};

const editPassword = () => {
    formEditPassword.post(route('dashboard.profile.resetpassword.post'), {
        onStart: () => formEditProfile.clearErrors(),
        onSuccess: () => formEditPassword.reset(),
    });
};
</script>

<template>
    <DashboardLayout>
        <LinedTitle :title="t('profile.profile')" />
        <div class="card mt-12">
            <div class="grid grid-cols-2 gap-4 w-full">
                <InputWapper 
                    v-model="formEditProfile.firstname" 
                    :title="t('firstname')" 
                    :error="formEditProfile.errors.firstname"
                    :required="true" 
                />
                <InputWapper
                    v-model="formEditProfile.lastname" 
                    :title="t('lastname')" 
                    :error="formEditProfile.errors.lastname"
                    :required="true" 
                />
            </div>
            <InputWapper
                v-model="formEditProfile.email" 
                :title="t('email')" 
                :error="formEditProfile.errors.email"
                :required="true"
                class="mt-4"
            />

            <button @click="editProfile()" class="btn primary mt-4 sm">
                {{t("profile.edit_profile")}}
            </button>
        </div>

        <LinedTitle :title="t('profile.reset_password')" class="mt-12" />
        <div class="card mt-12">
            <InputWapper 
                v-model="formEditPassword.old_password" 
                :title="t('profile.old_password')" 
                :error="formEditPassword.errors.old_password"
                :required="true"
                :type="'password'"
            />
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                <InputWapper
                    v-model="formEditPassword.password" 
                    :title="t('new_password')" 
                    :error="formEditPassword.errors.password"
                    :required="true"
                    :type="'password'"
                />
                <InputWapper
                    v-model="formEditPassword.password_confirmation" 
                    :title="t('new_password_confirmation')" 
                    :error="formEditPassword.errors.password_confirmation"
                    :required="true"
                    :type="'password'"
                />
            </div>

            <button @click="editPassword()" class="btn primary mt-4 sm">
                {{t("profile.edit_password")}}
            </button>
        </div>
    </DashboardLayout>
</template>
