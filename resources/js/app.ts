import { createApp, h } from 'vue';
    import '../css/app.css';
    import { createInertiaApp } from '@inertiajs/inertia-vue3';
    import { createPinia } from 'pinia';
    import { useUserStore } from '@/stores/user';

    createInertiaApp({
      resolve: name => import(`./Pages/${name}.vue`).then(m => m.default),
      setup({ el, app: App, props, plugin }) {
        const pinia = createPinia();
        const vueApp = createApp({ render: () => h(App, props) });
        vueApp.use(plugin);
        vueApp.use(pinia);

        const shared = (props as any).initialPage.props;
        const userStore = useUserStore();
        userStore.setUser(shared.auth?.user ?? null);

        vueApp.mount(el);
      },
    });
