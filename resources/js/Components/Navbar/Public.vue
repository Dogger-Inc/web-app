<script setup>
import { ref, onMounted, onUnmounted, watch } from 'vue';
import { useI18n } from 'vue-i18n';
import { Link, usePage } from '@inertiajs/vue3';
import { Bars3Icon, XMarkIcon } from '@heroicons/vue/24/outline';
import LanguageSelector from '@/Components/LanguageSelector.vue';
import Logo from '@assets/images/logo.png';

const { t } = useI18n({});
const isReduced = ref(true);
const isLoggedIn = usePage().props.auth.user !== null;

const anchors = [
    { id: '#features', text: t('navbar.public.features') },
    { id: '#pricing', text: t('navbar.public.pricing') },
    { id: '#faq', text: t('navbar.public.faq') },
];

watch(() => route.fullPath, () => {
    isReduced.value = true;
});

onMounted(() => {
    setNavbarDisplay();
    window.addEventListener('scroll', setNavbarDisplay);

    // add active to all <a> tag for anchors when scrolling
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            const id = entry.target.getAttribute('id');
            const navLinks = document.querySelectorAll(`nav a[href*="#${id}"]`);
            if (entry.isIntersecting) {
                navLinks.forEach((navLink) => navLink.classList.add('active'));
            } else {
                navLinks.forEach((navLink) => navLink.classList.remove('active'));
            }
        });
    }, {
        rootMargin: '0px 0px -50% 0px',
        threshold: 0.2,
    });

    anchors.forEach((anchor) => {
        const section = document.querySelector(anchor.id);
        if (section) observer.observe(section);
    });
});

onUnmounted(() => {
    window.removeEventListener('scroll', setNavbarDisplay);
});

const openSideBar = () => isReduced.value = !isReduced.value;

function setNavbarDisplay() {
    const header = document.querySelector('header');
    let y = window.scrollY / 200;
    y = y > 0.7 ? 0.7 : y;
    header.style.backdropFilter = y > 0 ? `blur(${y * 10}px)` : 'none';
    header.style.backgroundColor = `rgba(${255}, ${255}, ${255}, ${y})`;
}
</script>

<template>
    <header>
        <!-- Tablet and Computer -->
        <nav class="hidden md:flex">
            <div class="logo-side">
                <Link :href="route('homepage')">
                    <img :src="Logo" alt="Dogger logo" width="45" height="45" />
                    <span class="sr-only">{{ $t('navbar.public.home') }}</span>
                </Link>
            </div>
            <div class="menu-side">
                <Link v-for="anchor in anchors" :key="anchor.id" :href="`${route('homepage')}/${anchor.id}`">
                    {{ anchor.text }}
                </Link>
                <Link :href="route('doc')" :class="{'active': route().current() === 'doc'}">
                    {{ $t('navbar.public.doc') }}
                </Link>
            </div>
            <div class="button-side relative">
                <LanguageSelector />
                <Link :href="route('login')" class="btn primary sm">
                    {{ isLoggedIn ? $t('mainpage') : $t('signin') }}
                </Link>
            </div>
        </nav>
        <!-- Mobile -->
        <nav class="flex justify-between md:hidden">
            <div class="flex items-center gap-3 md:gap-6 justify-end mr-auto z-30">
                <Bars3Icon v-if="isReduced" class="w-6 h-6" @click="openSideBar" />
                <XMarkIcon v-else class="w-6 h-6" @click="openSideBar" />
            </div>
            
            <div class="flex items-center gap-3">
                <Link :href="route('login')" class="btn primary xs">
                    {{ isLoggedIn ? $t('mainpage') : $t('signin') }}
                </Link>
                <LanguageSelector />
                <Link :href="route('homepage')" class="mb-2">
                    <img :src="Logo" alt="Dogger logo" width="40" height="40" />
                    <span class="sr-only">{{ $t('navbar.public.home') }}</span>
                </Link>
            </div>

            <div id="sidebar" :class="{'reduced' : isReduced}">
                <div class="relative flex flex-col justify-center gap-24 px-5 py-5 text-3xl h-full">
                    <Link v-for="anchor in anchors" :key="anchor.id" :href="`${route('homepage')}/${anchor.id}`">
                        {{ anchor.text }}
                    </Link>
                    <Link :href="route('doc')" :class="{'active': route().current() === 'doc'}">
                        {{ $t('navbar.public.doc') }}
                    </Link>
                </div>
            </div>
        </nav>
    </header>
</template>

<style lang="scss" scoped>
header {
    @apply sticky top-0 w-full z-10;

    nav {
        @apply justify-between items-center max-w-7xl h-14 md:h-16 mx-auto px-4 md:px-10;

        a {
            @apply text-dogger-gray-dark;
            
            &.active {
                @apply text-dogger-orange-500 font-semibold;
            }
        }
    
        .logo-side {
            @screen lg {
                width: 175px;
            }
        }
    
        .menu-side {
            @apply flex items-center gap-8 justify-center;
        }
    
        .button-side {
            @apply flex items-center gap-3 justify-end;

            @screen lg {
                width: 175px;
            }
        }
        #sidebar {
            @apply bg-white/90 z-20 absolute inset-0 w-full text-center;
            height: 100svh;
            backdrop-filter: blur(4px);
            pointer-events: all;
            transition: opacity 400ms ease 0ms;

            a {
                text-shadow:  1px 1px 3px #F2F2F2;
                &.router-link-exact-active {
                    text-shadow:  1px 1px 3px #ff5f0b;
                }
            }

            &.reduced {
                @apply opacity-0 pointer-events-none z-0;
                transition: opacity 400ms ease 0ms;
            }
        }
    }
}
</style>