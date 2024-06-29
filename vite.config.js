import { fileURLToPath, URL } from 'node:url'

import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import vueJsx from '@vitejs/plugin-vue-jsx';

const vueConfig = {
    template: {
        transformAssetUrls: {
            base: null,
            includeAbsolute: false,
        },
    },
};

// https://vitejs.dev/config/
export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/app.js',
                'resources/js/mini-games/square-man/app.js',
            ],
            refresh: true,
        }),
        vue(vueConfig),
        vueJsx(vueConfig),
    ],
    resolve: {
        alias: {
            '@': fileURLToPath(new URL('./resources/js', import.meta.url)),
            '@resources': fileURLToPath(new URL('./resources', import.meta.url)),
            '@public': fileURLToPath(new URL('./public', import.meta.url)),
            '@asset': fileURLToPath(new URL('./public', import.meta.url)),
            '@CRUD': fileURLToPath(new URL('./resources/js/Pages/CRUD', import.meta.url)),
            '@SvgIcons': fileURLToPath(new URL('./resources/js/SvgIcons', import.meta.url)),
            '@EasyCrud': fileURLToPath(new URL('./resources/js/EasyCrud', import.meta.url)),
        }
    },
    build: {
        /**
        * https://vitejs.dev/guide/build
        * https://v3.vitejs.dev/guide/build.html
        */
        rollupOptions: {
          // https://rollupjs.org/guide/en/#big-list-of-options
        }
    },
});
