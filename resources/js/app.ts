import { createApp, h } from 'vue';
import '../css/app.css';
import './bootstrap';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import { createPinia } from 'pinia';
import { useAuthStore } from './stores/auth';

InertiaProgress.init({ delay: 250 });

createInertiaApp({
    resolve: name => import(`./Pages/${name}.vue`).then(m => m.default),
    setup({ el, app, props, plugin }) {
        const vueApp = createApp({ render: () => h(app, props) });
        const pinia = createPinia();
        vueApp.use(plugin).use(pinia);

        useAuthStore().init().catch(error => {
            console.error('Error initializing auth store:', error);
        });

        vueApp.mount(el);
    },
}).catch(error => {
    console.error('Error creating Inertia app:', error);
});
