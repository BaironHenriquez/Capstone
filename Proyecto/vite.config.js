import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/css/baieco.css',
                'resources/js/app.js',
                'resources/js/baieco.js'
            ],
            refresh: true,
        }),
    ],
    css: {
        postcss: './postcss.config.js',
    },
    server: {
        host: '0.0.0.0',
        port: 5173,
        strictPort: true,
        watch: {
            usePolling: true,
        },
        hmr: {
            host: 'localhost',
            port: 5173,
        },
    },
});
