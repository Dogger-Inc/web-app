import '../scss/app.scss';

import { createSSRApp, h } from 'vue';
import createServer from '@inertiajs/vue3/server';
import { createInertiaApp } from '@inertiajs/vue3';
import { renderToString } from '@vue/server-renderer';

import { ZiggyVue } from 'ziggy-js';

createServer(page =>
    createInertiaApp({
        page,
        render: renderToString,
        resolve: name => {
            const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
            return pages[`./Pages/${name}.vue`]
        },
        setup({ App, props, plugin }) {
            return createSSRApp({
                render: () => h(App, props),
            })
                .use(plugin)
                .use(ZiggyVue)
        },
    }),
)