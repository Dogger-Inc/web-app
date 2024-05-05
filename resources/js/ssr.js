import '../scss/app.scss';

import { createSSRApp, h } from 'vue';
import createServer from '@inertiajs/vue3/server';
import { createInertiaApp } from '@inertiajs/vue3';
import { renderToString } from '@vue/server-renderer';

import { createI18n } from 'vue-i18n'
import { loadLocaleMessages, dateTimeFormats } from './i18n';

import { ZiggyVue } from 'ziggy-js';
import { Ziggy } from './ziggy';

createServer(page =>
    createInertiaApp({
        page,
        render: renderToString,
        resolve: name => {
            const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
            return pages[`./Pages/${name}.vue`]
        },
        setup({ App, props, plugin }) {
            const i18n = createI18n({
                legacy: false,
                locale: props.initialPage.props.locale,
                fallbackLocale: import.meta.env.FALLBACK_LOCALE,
                messages: loadLocaleMessages(),
                dateTimeFormats
            })
            return createSSRApp({
                render: () => h(App, props),
            })
                .use(plugin)
                .use(i18n)
                .use(ZiggyVue, Ziggy)
        },
    }),
)