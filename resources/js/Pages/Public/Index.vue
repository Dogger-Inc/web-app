<script setup>
import { Link } from '@inertiajs/vue3';
import {
    ChartBarIcon,
    CloudArrowUpIcon,
    BoltIcon,
    ArrowTrendingUpIcon,
} from '@heroicons/vue/24/outline';
import { CheckIcon, CheckBadgeIcon } from '@heroicons/vue/20/solid';
import PublicLayout from '@/Layouts/Public.vue';
import MainIllustration from '@assets/images/main_illustration.png';
import { useI18n } from "vue-i18n"; 
import LangageSelector from '../../Components/Items/LangageSelector.vue';

const { t } = useI18n({});
const features = [
    {
        name: t("homepage.features.easy_to_implement.title"),
        description: t("homepage.features.easy_to_implement.description"),
        icon: CloudArrowUpIcon,
    },
    {
        name: t("homepage.features.immediate.title"),
        description: t("homepage.features.immediate.description"),
        icon: BoltIcon,
    },
    {
        name: t("homepage.features.stats_friendly.title"),
        description: t("homepage.features.stats_friendly.description"),
        icon: ChartBarIcon,
    },
    {
        name: t("homepage.features.scallable.title"),
        description: t("homepage.features.scallable.description"),
        icon: ArrowTrendingUpIcon,
    },
]
const tiers = [
    {
        name: t("homepage.tiers.free.name"),
        id: 'tier-free',
        href: 'https://github.com/Dogger-Inc',
        priceMonthly: '$0',
        description: t("homepage.tiers.free.description"),
        features: [
            t("homepage.tiers.free.features.self_host"),
            t("homepage.tiers.free.features.projects"),
            t("homepage.tiers.free.features.errors"),
            t("homepage.tiers.free.features.users")
        ],
        mostPopular: false,
    },
    {
        name: t("homepage.tiers.startup.name"),
        id: 'tier-startup',
        href: '#',
        priceMonthly: '$19',
        description: t("homepage.tiers.startup.description"),
        features: [
            t("homepage.tiers.startup.features.projects"),
            t("homepage.tiers.startup.features.errors"),
            t("homepage.tiers.startup.features.users"),
            t("homepage.tiers.startup.features.email")
        ],
        mostPopular: true,
    },
    {
        name: t("homepage.tiers.entreprise.name"),
        id: 'tier-enterprise',
        href: '#',
        priceMonthly: '$49',
        description: t("homepage.tiers.entreprise.description"),
        features: [
            t("homepage.tiers.entreprise.features.projects"),
            t("homepage.tiers.entreprise.features.errors"),
            t("homepage.tiers.entreprise.features.users"),
            t("homepage.tiers.entreprise.features.email"),
            t("homepage.tiers.entreprise.features.support")
        ],
        mostPopular: false,
    },
]
const faqs = [
    {
        id: 1,
        question: t("homepage.faqs.implementation.question"),
        answer: t("homepage.faqs.implementation.answer"),
        link: "https://github.com/Dogger-Inc"
    },
    {
        id: 2,
        question: t("homepage.faqs.open_source.question"),
        answer: t("homepage.faqs.open_source.question"),
        link: "https://github.com/Dogger-Inc"
    }
]
</script>

<template>
    <PublicLayout>
        <LangageSelector />
        <!-- Hero section -->
        <div class="relative pt-4 md:pt-8">
            <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80">
                <svg class="relative left-[calc(50%-11rem)] -z-10 h-[21.1875rem] max-w-none -translate-x-1/2 rotate-[30deg] sm:left-[calc(50%-30rem)] sm:h-[42.375rem]"
                    viewBox="0 0 1155 678">
                    <path fill="url(#9b2541ea-d39d-499b-bd42-aeea3e93f5ff)" fill-opacity=".3"
                        d="M317.219 518.975L203.852 678 0 438.341l317.219 80.634 204.172-286.402c1.307 132.337 45.083 346.658 209.733 145.248C936.936 126.058 882.053-94.234 1031.02 41.331c119.18 108.451 130.68 295.337 121.53 375.223L855 299l21.173 362.054-558.954-142.079z" />
                    <defs>
                        <linearGradient id="9b2541ea-d39d-499b-bd42-aeea3e93f5ff" x1="1155.49" x2="-78.208" y1=".177"
                            y2="474.645" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#ff8437" />
                            <stop offset="1" stop-color="#ff5f0b" />
                        </linearGradient>
                    </defs>
                </svg>
            </div>
            <div class="py-6">
                <div class="mx-auto max-w-7xl px-6 lg:px-8">
                    <div class="mx-auto max-w-2xl text-center">
                        <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">Dogger</h1>
                        <p class="mt-6 text-lg leading-8 text-gray-600">{{ $t('homepage.catchline') }}</p>
                        <div class="mt-10 flex items-center justify-center gap-x-6">
                            <Link :href="route('login')"
                                class="rounded-md bg-dogger-orange-400 px-8 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-dogger-orange-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                {{ $t('signin') }}
                            </Link>
                            <a href="#feature" class="text-sm font-semibold leading-6 text-gray-900">{{ $t('learnmore') }}
                                <span aria-hidden="true">→</span>
                            </a>
                        </div>
                    </div>
                    <div class="mt-16 flow-root sm:mt-24">
                        <div
                            class="-m-2 rounded-xl bg-gray-900/5 p-2 ring-1 ring-inset ring-gray-900/10 lg:-m-4 lg:rounded-2xl lg:p-4">
                            <img :src="MainIllustration"
                                alt="App screenshot" width="2432" height="1442"
                                class="rounded-md shadow-2xl ring-1 ring-gray-900/10" />
                        </div>
                    </div>
                </div>
            </div>
            <div
                class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]">
                <svg class="relative left-[calc(50%+3rem)] h-[21.1875rem] max-w-none -translate-x-1/2 sm:left-[calc(50%+36rem)] sm:h-[42.375rem]"
                    viewBox="0 0 1155 678">
                    <path fill="url(#b9e4a85f-ccd5-4151-8e84-ab55c66e5aa1)" fill-opacity=".3"
                        d="M317.219 518.975L203.852 678 0 438.341l317.219 80.634 204.172-286.402c1.307 132.337 45.083 346.658 209.733 145.248C936.936 126.058 882.053-94.234 1031.02 41.331c119.18 108.451 130.68 295.337 121.53 375.223L855 299l21.173 362.054-558.954-142.079z" />
                    <defs>
                        <linearGradient id="b9e4a85f-ccd5-4151-8e84-ab55c66e5aa1" x1="1155.49" x2="-78.208" y1=".177"
                            y2="474.645" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#ff8437" />
                            <stop offset="1" stop-color="#ff5f0b" />
                        </linearGradient>
                    </defs>
                </svg>
            </div>
        </div>

        <!-- Feature section -->
        <div id="feature" class="mx-auto mt-6 max-w-7xl px-6 sm:mt-32 lg:px-8">
            <div class="mx-auto max-w-2xl py-12 lg:text-center">
                <h2 class="text-base font-semibold leading-7 text-dogger-orange-400">{{ $t('homepage.use_dogger') }}</h2>
                <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                    {{ $t('homepage.need_dogger') }}
                </p>
                <p class="mt-6 text-lg leading-8 text-gray-600">
                    {{ $t('homepage.utility_dogger') }}
                </p>
            </div>
            <div class="mx-auto mt-16 max-w-2xl sm:mt-20 lg:mt-24 lg:max-w-4xl">
                <dl class="grid max-w-xl grid-cols-1 gap-y-10 gap-x-8 lg:max-w-none lg:grid-cols-2 lg:gap-y-16">
                    <div v-for="feature in features" :key="feature.name" class="relative pl-16">
                        <dt class="text-base font-semibold leading-7 text-gray-900">
                            <div class="absolute top-0 left-0 flex h-10 w-10 items-center justify-center rounded-lg bg-dogger-orange-400">
                                <component :is="feature.icon" class="h-6 w-6 text-white" aria-hidden="true" />
                            </div>
                            {{ feature.name }}
                        </dt>
                        <dd class="mt-2 text-base leading-7 text-gray-600">{{ feature.description }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Testimonial section -->
        <div class="mx-auto mt-32 max-w-7xl sm:mt-56 sm:px-6 lg:px-8">
            <div
                class="relative overflow-hidden bg-gray-900 py-20 px-6 shadow-xl sm:rounded-3xl sm:py-24 sm:px-10 md:px-12 lg:px-20">
                <img class="absolute inset-0 h-full w-full object-cover brightness-150 saturate-0"
                    src="https://images.unsplash.com/photo-1601381718415-a05fb0a261f3?ixid=MXwxMjA3fDB8MHxwcm9maWxlLXBhZ2V8ODl8fHxlbnwwfHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1216&q=80"
                    alt="" />
                <div class="absolute inset-0 bg-gray-900/90 mix-blend-multiply" />
                <svg viewBox="0 0 1097 845" aria-hidden="true"
                    class="absolute -top-56 -left-80 w-[68.5625rem] transform-gpu blur-3xl">
                    <path fill="url(#68eb76c4-2bc9-4928-860e-70adf05719f4)" fill-opacity=".45" d="M301.174 646.641 193.541 844.786 0 546.172l301.174 100.469 193.845-356.855c1.241 164.891 42.802 431.935 199.124 180.978 195.402-313.696 143.295-588.18 284.729-419.266 113.148 135.13 124.068 367.989 115.378 467.527L811.753 372.553l20.102 451.119-530.681-177.031Z" />
                    <defs>
                        <linearGradient id="68eb76c4-2bc9-4928-860e-70adf05719f4" x1="1097.04" x2="-141.165" y1=".22"
                            y2="363.075" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#ff8437" />
                            <stop offset="1" stop-color="#ff5f0b" />
                        </linearGradient>
                    </defs>
                </svg>
                <svg viewBox="0 0 1097 845" aria-hidden="true" class="hidden md:absolute md:bottom-16 md:left-[50rem] md:block md:w-[68.5625rem] md:transform-gpu md:blur-3xl">
                    <path fill="url(#68eb76c4-2bc9-4928-860e-70adf05719f4)" fill-opacity=".25" d="M301.174 646.641 193.541 844.786 0 546.172l301.174 100.469 193.845-356.855c1.241 164.891 42.802 431.935 199.124 180.978 195.402-313.696 143.295-588.18 284.729-419.266 113.148 135.13 124.068 367.989 115.378 467.527L811.753 372.553l20.102 451.119-530.681-177.031Z" />
                </svg>
                <div class="relative mx-auto max-w-2xl lg:mx-0">
                    <div class="flex items-center gap-3 text-white">
                        <CheckBadgeIcon class="h-10 w-10" />
                        <h3 class="text-2xl font-extrabold">
                            {{ $t('homepage.missions') }}
                        </h3>
                    </div>
                    <figure>
                        <blockquote class="mt-6 text-lg font-semibold text-white sm:text-xl sm:leading-8">
                            <p>
                                {{ $t('homepage.quote') }}
                            </p>
                        </blockquote>
                        <figcaption class="mt-6 text-base text-white">
                            <div class="mt-1">{{ $t('homepage.ceo') }}</div>
                        </figcaption>
                    </figure>
                </div>
            </div>
        </div>

        <!-- Pricing section -->
        <div class="py-24 sm:pt-48">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="mx-auto max-w-4xl text-center">
                    <h2 class="text-base font-semibold leading-7 text-dogger-orange-400">{{ $t('homepage.pricing') }}</h2>
                    <p class="mt-2 text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl">
                        {{ $t('homepage.pricing_plan') }}
                    </p>
                </div>
                <p class="mx-auto mt-6 max-w-2xl text-center text-lg leading-8 text-gray-600">
                    {{ $t('homepage.pricing_plan_fit') }}
                </p>
                <div
                    class="isolate mx-auto mt-16 grid max-w-md grid-cols-1 gap-y-8 sm:mt-20 lg:mx-0 lg:max-w-none lg:grid-cols-3">
                    <div v-for="(tier, tierIdx) in tiers" :key="tier.id"
                        :class="[tier.mostPopular ? 'lg:z-10 lg:rounded-b-none' : 'lg:mt-8', tierIdx === 0 ? 'lg:rounded-r-none' : '', tierIdx === tiers.length - 1 ? 'lg:rounded-l-none' : '', 'flex flex-col justify-between rounded-3xl bg-white p-8 ring-1 ring-gray-200 xl:p-10']">
                        <div>
                            <div class="flex items-center justify-between gap-x-4">
                                <h3 :id="tier.id" :class="[tier.mostPopular ? 'text-dogger-orange-400' : 'text-gray-900', 'text-lg font-semibold leading-8']">
                                    {{ tier.name }}
                                </h3>
                                <p v-if="tier.mostPopular" class="rounded-full bg-dogger-orange-400/10 py-1 px-2.5 text-xs font-semibold leading-5 text-dogger-orange-400">
                                    {{ $t('homepage.pricing_popular') }}
                                </p>
                            </div>
                            <p class="mt-4 text-sm leading-6 text-gray-600">{{ tier.description }}</p>
                            <p class="mt-6 flex items-baseline gap-x-1">
                                <span class="text-4xl font-bold tracking-tight text-gray-900">
                                    {{ tier.priceMonthly }}
                                </span>
                                <span class="text-sm font-semibold leading-6 text-gray-600">{{ $t('homepage.pricing_per_month') }}</span>
                            </p>
                            <ul role="list" class="mt-8 space-y-3 text-sm leading-6 text-gray-600">
                                <li v-for="feature in tier.features" :key="feature" class="flex gap-x-3">
                                    <CheckIcon class="h-6 w-5 flex-none text-dogger-orange-400" aria-hidden="true" />
                                    {{ feature }}
                                </li>
                            </ul>
                        </div>
                        <a :href="tier.href" :aria-describedby="tier.id" :class="[tier.mostPopular ? 'bg-dogger-orange-400 text-white shadow-sm hover:bg-dogger-orange-500' : 'text-dogger-orange-400 ring-1 ring-inset ring-orange-400 hover:ring-orange-500', 'mt-8 block rounded-md py-2 px-3 text-center text-sm font-semibold leading-6 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600']">
                            {{ tier.id === 'tier-free' ? $t('homepage.pricing_tier_free') : $t('homepage.pricing_buy_plan') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- FAQs -->
        <div
            class="mx-auto max-w-2xl divide-y divide-gray-900/10 px-6 pb-8 sm:pt-12 sm:pb-24 lg:max-w-7xl lg:px-8 lg:pb-32">
            <h2 class="text-2xl font-bold leading-10 tracking-tight text-gray-900">{{ $t('homepage.frequently_question') }}</h2>
            <dl class="mt-10 space-y-8 divide-y divide-gray-900/10">
                <div v-for="faq in faqs" :key="faq.id" class="pt-8 lg:grid lg:grid-cols-12 lg:gap-8">
                    <dt class="text-base font-semibold leading-7 text-gray-900 lg:col-span-5">{{ faq.question }}</dt>
                    <dd class="mt-4 lg:col-span-7 lg:mt-0">
                        <p class="text-base leading-7 text-gray-600">{{ faq.answer }}</p>
                        <span v-if="faq.link" class="block mt-4 text-sm font-semibold leading-6 text-dogger-orange-400">
                            <a target="_blank" href="https://github.com/Oui-Dev/Dogger-V2/">{{ faq.link }}</a>
                        </span>
                    </dd>
                </div>
            </dl>
        </div>
    </PublicLayout>
</template>