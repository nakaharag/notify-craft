// vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue      from '@vitejs/plugin-vue';
import path     from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.ts','resources/css/app.css'],
            refresh: true,
        }),
        vue(),
    ],
    resolve: {
        alias: { '@': path.resolve(__dirname,'resources/js') },
    },
    server: {
        cors: true,
        strictPort: true,
        host: 'localhost',
        port: 5173,
        hmr: { host: 'localhost', protocol: 'ws', port: 5173, clientPort: 5173 },
        proxy: {
            '/api':     { target: 'http://localhost', changeOrigin: true },
            '/sanctum': { target: 'http://localhost', changeOrigin: true },
        },
    },
});
