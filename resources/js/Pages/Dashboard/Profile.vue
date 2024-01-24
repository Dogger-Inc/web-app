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
        onStart: () => {
            formEditPassword.clearErrors();
            formEditPassword.newPasswordConfirmation = '';
        },
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
                    :title="t('profile.firstname')" 
                    :error="formEditProfile.errors.firstname"
                    :required="true" 
                />
                <InputWapper
                    v-model="formEditProfile.lastname" 
                    :title="t('profile.lastname')" 
                    :error="formEditProfile.errors.lastname"
                    :required="true" 
                />
            </div>
            <InputWapper
                    v-model="formEditProfile.email" 
                    :title="t('profile.email')" 
                    :error="formEditProfile.errors.email"
                    :required="true"
                    class="mt-4"
            />
            <div class="flex">
                <button @click="editProfile()" class="btn primary mt-4 sm">
                    {{t("profile.edit_profile")}}
                </button>
            </div>
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
                    :title="t('profile.new_password')" 
                    :error="formEditPassword.errors.password"
                    :required="true"
                    :type="'password'"
                />
                <InputWapper
                    v-model="formEditPassword.password_confirmation" 
                    :title="t('profile.new_password_confirmation')" 
                    :error="formEditPassword.errors.password_confirmation"
                    :required="true"
                    :type="'password'"
                />
            </div>
            <div class="flex">
                <button @click="editPassword()" class="btn primary mt-4 sm">
                    {{t("profile.edit_password")}}
                </button>
            </div>

        </div>
    </DashboardLayout>
</template>
