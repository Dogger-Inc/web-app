import '../scss/app.scss';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { createI18n } from 'vue-i18n'
import { loadLocaleMessages, dateTimeFormats } from './i18n';

import Toast from 'vue-toastification';

import { ZiggyVue } from 'ziggy-js';

// Cookie consent
import { cc } from './cc';

createInertiaApp({
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
        return pages[`./Pages/${name}.vue`]
    },
    setup({ el, App, props, plugin }) {
   	 	const i18n = createI18n({
            legacy: false,
            locale: props.initialPage.props.locale,
            fallbackLocale: import.meta.env.FALLBACK_LOCALE,
            messages: loadLocaleMessages(),
            dateTimeFormats
        })
        const app = createApp({ render: () => h(App, props) })
            .use(plugin)
        	.use(i18n)
            .use(ZiggyVue)
            .use(Toast, {
                position: "top-right",
                timeout: 3000,
                maxToasts: 6,
                newestOnTop: true
            });

        app.config.globalProperties.cc = cc;
        app.mount(el);
    },
    progress: {
        color: '#ff8437',
    },
});
