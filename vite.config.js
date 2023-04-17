import {fileURLToPath, URL} from 'node:url'
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {
        watch: {
            usePolling: true,
        },
    },
    resolve: {
        alias: {
            '@': fileURLToPath(new URL('resources/js', import.meta.url)),
        }
    }
});
