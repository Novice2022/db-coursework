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
        host: '0.0.0.0',
        hmr: {
            host: 'localhost',
        },
        proxy: {
            '/': {
                target: 'http://localhost:9000', // ваш Laravel сервер
                changeOrigin: true,
                ws: true,
            },
        },
    },
});
