<script setup>
import { ref } from 'vue';
import { useForm, Link } from '@inertiajs/vue3';
import InputWrapper from '@/Components/Form/InputWrapper.vue';
import AuthLayout from '@/Layouts/Auth.vue';
import { useI18n } from 'vue-i18n';
const { t } = useI18n({});

const props = defineProps({
    disabledDuration: {
        type: Number,
        required: true,
    },
});

const disabledRemainingTime = ref(0);
const isSuccess = ref(false);
const form = useForm({
    email: '',
});

const startTimer = () => {
    disabledRemainingTime.value = props.disabledDuration;

    const timer = setInterval(() => {
        disabledRemainingTime.value--;
        if (disabledRemainingTime.value <= 0) {
            clearInterval(timer);
        }
    }, 1000);
};

const submit = () => {
    form.post(route('password.email'), {
        onStart: () => form.clearErrors(),
        onSuccess: () => {
            isSuccess.value = true;
            startTimer();
        },
    });
};
</script>

<template>
    <AuthLayout>
        <template v-slot:header>
            <h2 class="mt-6 text-center text-2xl md:text-3xl font-bold tracking-tight text-gray-900">
                {{ $t('password_forgotten') }}
            </h2>
        </template>

        <template v-if="isSuccess">
            <div class="font-medium text-lg text-center">
                <p>
                    <span>{{ $t('forgot_password.confirm_mail') }}</span> {{ $t('forgot_password.confirm_mail_text') }} <span>{{ form.email }}</span> !
                </p>
                <p class="mt-4">{{ $t('forgot_password.check_mail') }}</p>
            </div>
            <button
                @click.prevent="submit"
                :disabled="disabledRemainingTime > 0 || form.processing"
                class="btn generic mt-10 !w-full"
            >
                {{ $t('forgot_password.send_new_code') }} {{ disabledRemainingTime > 0 ? `(${disabledRemainingTime}s)` : '' }}
            </button>
        </template>
        <form v-else @submit.prevent="submit" class="flex flex-col gap-5 lg:gap-6">
            <InputWrapper
                v-model="form.email"
                :error="form.errors.email"
                :title="t('email')"
                type="email"
            />

            <button type="submit" :disabled="form.processing" class="btn primary !w-full mt-5">
                {{ $t('send_code') }}
            </button>
            <Link :href="route('login')" class="btn generic !w-full">
                {{ $t('go_back') }}
            </Link>
        </form>
    </AuthLayout>
</template>

<style lang="scss" scoped>
p > span {
    @apply font-bold text-dogger-orange-400;
}
</style>