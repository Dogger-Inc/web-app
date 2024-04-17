<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { Bars3Icon, XMarkIcon } from '@heroicons/vue/24/outline';
import {
    Disclosure,
    DisclosureButton,
    DisclosurePanel,
    Menu,
    MenuButton,
    MenuItem,
    MenuItems
} from '@headlessui/vue';
import Avatar from '@/Components/Avatar.vue';
import LanguageSelector from '@/Components/LanguageSelector.vue';
import Logo from '@assets/images/logo.png';
import { useI18n } from 'vue-i18n';
const { t } = useI18n({});

const navigation = [
    { name: t('navbar.dashboard.dashboard'), href: 'dashboard.index' },
    { name: t('navbar.dashboard.companies'), href: 'dashboard.companies.list' },
    { name: t('navbar.dashboard.projects'), href: 'dashboard.projects.list' },
    { name: t('navbar.dashboard.issues'), href: 'dashboard.issues.list' },
    // { name: t('navbar.dashboard.performances'), href: '#' },
    { name: t('navbar.dashboard.documentation'), href: 'doc' },
];

const profileNavigation = [
    { name: t('navbar.dashboard.profile'), href: 'dashboard.profile.show' },
    { name: t('navbar.dashboard.signout'), href: 'logout' },
];

const isCurrentRoute = (path) => {
    return usePage().props.route.name === path;
}
</script>

<template>
    <Disclosure as="nav" class="bg-white" v-slot="{ open }">
        <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
            <div class="relative flex h-16 items-center justify-between">
                <div class="flex items-center sm:hidden">
                    <!-- Mobile menu button-->
                    <DisclosureButton class="relative inline-flex items-center justify-center rounded-md p-1 text-gray-400">
                        <span class="sr-only">{{ $t('navbar.dashboard.main_menu') }}</span>
                        <Bars3Icon v-if="!open" class="block h-6 w-6" aria-hidden="true" />
                        <XMarkIcon v-else class="block h-6 w-6" aria-hidden="true" />
                    </DisclosureButton>
                </div>
                <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                    <Link :href="route('homepage')" class="flex flex-shrink-0 items-center">
                        <img :src="Logo" alt="Dogger logo" class="h-8 w-auto" />
                    </Link>
                    <div class="hidden sm:ml-6 sm:block">
                        <div class="flex space-x-4">
                            <Link
                                v-for="item in navigation" :key="item.name" :href="route(item.href)"
                                :class="[isCurrentRoute(item.href) ? 'bg-gray-100' : 'hover:bg-gray-50', 'rounded-md px-3 py-2 font-medium']"
                                :aria-current="isCurrentRoute(item.href) ? 'page' : undefined"
                            >
                                {{ item.name }}
                            </Link>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-3 pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
                    <LanguageSelector />
                    <!-- Profile dropdown -->
                    <Menu as="div" class="relative inline-flex">
                        <MenuButton>
                            <Avatar/>
                            <span class="sr-only">{{ $t('navbar.dashboard.user_menu') }}</span>
                        </MenuButton>

                        <Transition
                            enter-active-class="transition ease-out duration-100"
                            enter-from-class="transform opacity-0 scale-95"
                            enter-to-class="transform opacity-100 scale-100"
                            leave-active-class="transition ease-in duration-75"
                            leave-from-class="transform opacity-100 scale-100"
                            leave-to-class="transform opacity-0 scale-95"
                        >
                            <MenuItems class="absolute top-8 right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-gray-50 py-1 shadow-lg">
                                <MenuItem v-for="item in profileNavigation" :key="item.name" v-slot="{ active }">
                                    <Link :href="route(item.href)" :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">
                                        {{ item.name }}
                                    </Link>
                                </MenuItem>
                            </MenuItems>
                        </Transition>
                    </Menu>
                </div>
            </div>
        </div>

        <DisclosurePanel class="sm:hidden">
            <div class="space-y-1 px-2 pb-3 pt-2">
                <DisclosureButton
                    v-for="item in navigation" :key="item.name"
                    :class="[isCurrentRoute(item.href) ? 'bg-gray-100' : 'hover:bg-gray-50', 'block rounded-md px-3 py-2 text-base font-medium']"
                    :aria-current="isCurrentRoute(item.href) ? 'page' : undefined"
                >
                    <Link :href="route(item.href)">
                        {{ item.name }}
                    </Link>
                </DisclosureButton>
            </div>
        </DisclosurePanel>
    </Disclosure>
</template>
