<script setup>
import { computed, watch, onMounted } from 'vue';
import { useI18n } from 'vue-i18n';
import { useForm, usePage } from '@inertiajs/vue3';
import {
    Listbox,
    ListboxButton,
    ListboxLabel,
    ListboxOption,
    ListboxOptions
} from '@headlessui/vue';
// Flags imports
import FrFlag from '@assets/flags/fr.svg';
import EnFlag from '@assets/flags/en.svg';
import DeFlag from '@assets/flags/de.svg';
import ZhFlag from '@assets/flags/zh.svg';
import JaFlag from '@assets/flags/ja.svg';
import RuFlag from '@assets/flags/ru.svg';

const { t } = useI18n({});

const langs = [
    { name: 'English', value: 'en', flag: EnFlag },
    { name: 'Français', value: 'fr', flag: FrFlag },
    { name: 'Deutsch', value: 'de', flag: DeFlag },
    { name: '中文', value: 'zh', flag: ZhFlag },
    { name: '日本語', value: 'ja', flag: JaFlag },
    { name: 'Русский', value: 'ru', flag: RuFlag }
];

const form = useForm({
    locale: usePage().props.locale,
});

const currentLocale = computed(() => {
    return langs.find((lang) => lang.value === form.locale);
});

watch(() => form.isDirty, () => {
    form.get(route('locale.set', { locale: form.locale }), {
        onSuccess: () => {
            localStorage.setItem('locale', form.locale);
            window.location.reload();
        },
    });
});

onMounted(() => {
    const savedLocale = localStorage.getItem('locale');
    if (savedLocale) {
        // If the saved locale is different from the current one, we update the form manually to trigger the watch
        if(savedLocale !== form.locale) {
            form.locale = savedLocale;
        } else {
            form.defaults('locale', savedLocale);
        }
    }
});
</script>

<template>
    <Listbox as="div" v-model="form.locale" class="relative inline-flex">
        <ListboxLabel class="sr-only">Language selector</ListboxLabel>

        <ListboxButton>
            <img
                :src="currentLocale.flag"
                :alt="currentLocale.name + ' flag'"
                class="h-6 w-6"
            />
        </ListboxButton>

        <transition
            leave-active-class="transition ease-in duration-100"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <ListboxOptions>
                <ListboxOption
                    v-for="lang in langs"
                    :key="lang.value"
                    :value="lang.value"
                    v-slot="{ active, selected }"
                    as="template"
                >
                    <li :class="active || selected ? 'bg-dogger-orange-400 text-white' : 'text-gray-900'">
                        <img
                            :src="lang.flag"
                            :alt="lang.name + ' flag'"
                            class="h-5 w-5"
                        />
                        <p :class="selected ? 'font-bold' : 'font-normal'">{{ lang.name }}</p>
                    </li>
                </ListboxOption>
            </ListboxOptions>
        </transition>
    </Listbox>
</template>

<style lang="scss" scoped>
ul {
    @apply absolute top-8 right-0 z-50 min-w-36 divide-y divide-gray-200 rounded-md bg-gray-50 shadow-lg;

    li {
        @apply cursor-pointer px-4 py-3 text-sm flex gap-6;
    }
    li:first-child {
        @apply rounded-t-md;
    }
    li:last-child {
        @apply rounded-b-md;
    }
}
</style>