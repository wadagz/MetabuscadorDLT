import './bootstrap';
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import VueSplide from '@splidejs/vue-splide';
import AppLayout from './Layouts/App.vue';
import { ZiggyVue } from 'ziggy-js';

createInertiaApp({
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true });
        let page =  pages[`./Pages/${name}.vue`];
        page.default.layout = page.default.layout || AppLayout;

        return page;
    },
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) });
        app.use(plugin);
        app.use(VueSplide);
        app.use(ZiggyVue);
        app.mount(el);
        return app;
    },
})
