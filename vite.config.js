import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig(({ mode }) => {
    return {
        plugins: [
            laravel({
                input: [
                    'resources/css/app.css',
                    'resources/css/aems.css',
                    'resources/css/aems_respon.css',
                    'resources/js/app.js'
                ],
                refresh: true,
            }),
        ],
        server: {
            https: mode === 'production', 
        },
    };
});
