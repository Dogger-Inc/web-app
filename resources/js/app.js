import '../scss/app.scss';
import 'vue-toastification/dist/index.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
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
        const app = createApp({ render: () => h(App, props) })
            .use(plugin)
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
