import { defineConfig, loadEnv } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default ({ mode }) => {
    const env = loadEnv(mode, process.cwd(), '');

    return defineConfig({
        plugins: [
            laravel({
                input: ['resources/css/app.css', 'resources/js/app.js'],
                refresh: true,
            }),
            tailwindcss(),
        ],
        server: {
            host: env.VITE_HOST || '0.0.0.0',
            hmr: {
                host: env.VITE_HMR_HOST,
            },
            watch: {
                ignored: ['**/storage/framework/views/**'],
            },
        },
    });
};

