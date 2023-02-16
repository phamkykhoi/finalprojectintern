import './bootstrap';
import '../css/app.css';
import * as bootstrap from 'bootstrap';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import ElementPlus from 'element-plus'
import 'element-plus/dist/index.css'

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, app, props, plugin }) {
        const appInstance = createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(ElementPlus, { locale: 'en' })
            .use(ZiggyVue, Ziggy);

        return appInstance.mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563' });
