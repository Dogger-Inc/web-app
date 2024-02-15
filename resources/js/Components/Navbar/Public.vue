<script setup>
import { ref, onMounted, onUnmounted, watch } from 'vue';
import { useI18n } from 'vue-i18n';
import { Link } from '@inertiajs/vue3';
import { Bars3Icon, XMarkIcon } from '@heroicons/vue/24/outline';
import LangageSelector from '@/Components/LangageSelector.vue';
import GithubIcon from '@assets/images/github.svg';
import Logo from '@assets/images/logo.png';

const { t } = useI18n({});
const isReduced = ref(true);

const anchors = [
    { id: '#features', text: t('navbar.public.features') },
    { id: '#our-mission', text: t('navbar.public.our_mission') },
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
            const navLinks = document.querySelectorAll(`nav a[href="#${id}"]`);
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
    y = y > 0.5 ? 0.5 : y;
    header.style.backdropFilter = y > 0 ? `blur(${y * 10}px)` : 'none';
    header.style.backgroundColor = `rgba(${255}, ${255}, ${255}, ${y})`;
}
</script>

<template>
    <header>
        <!-- Tablet and Computer -->
        <nav class="hidden md:flex">
            <div class="logo-side">
                <Link href="/">
                    <img :src="Logo" alt="Dogger logo" width="45" height="45" />
                    <span class="sr-only">{{ $t('navbar.public.home') }}</span>
                </Link>
            </div>
            <div class="menu-side">
                <a v-for="anchor in anchors" :key="anchor.id" :href="anchor.id" target="_self">
                    {{ anchor.text }}
                </a>
            </div>
            <div class="button-side relative">
                <LangageSelector />
                <a href="https://github.com/Dogger-Inc" target="_blank">
                    <span class="sr-only">Github</span>
                    <img :src="GithubIcon" alt="github logo" class="h-6 w-6" />
                </a>
            </div>
        </nav>
        <!-- Mobile -->
        <nav class="flex justify-between md:hidden">
            <div class="flex items-center gap-3 md:gap-6 justify-end mr-auto z-30">
                <Bars3Icon v-if="isReduced" class="w-6 h-6" @click="openSideBar" />
                <XMarkIcon v-else class="w-6 h-6" @click="openSideBar" />
            </div>
            
            <div class="flex items-center gap-3">
                <LangageSelector class="mt-2" />
                <Link href="/">
                    <img :src="Logo" alt="Dogger logo" width="40" height="40" />
                    <span class="sr-only">{{ $t('navbar.public.home') }}</span>
                </Link>
            </div>

            <div id="sidebar" :class="{'reduced' : isReduced}">
                <div class="relative flex flex-col justify-center gap-24 px-5 py-5 text-3xl h-full">
                    <a v-for="anchor in anchors" :key="anchor.id" :href="anchor.id" target="_self">
                        {{ anchor.text }}
                    </a>
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
                width: 60px;
            }
        }
    
        .menu-side {
            @apply flex items-center gap-8 justify-center;
        }
    
        .button-side {
            @apply flex items-center gap-3 justify-end;

            @screen lg {
                width: 60px;
            }

            a:hover {
                filter: invert(57%) sepia(59%) saturate(5893%) hue-rotate(353deg) brightness(103%) contrast(107%);
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