import { fileURLToPath, URL } from 'node:url'
import { createLogger , defineConfig, loadEnv } from 'vite'
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import vueJsx from '@vitejs/plugin-vue-jsx';

// BEGIN https://vitejs.dev/config/shared-options.html#customlogger

const logger = createLogger()
const loggerWarn = logger.warn;
const loggerError = logger.error;

logger.warn = (msg, options) => {
    console.log('logger.warn', {msg, options});

    // Ignore empty CSS files warning
    if (msg.includes('vite:css') && msg.includes(' is empty')) {
        return;
    }

    loggerWarn(msg, options)
}
// END https://vitejs.dev/config/shared-options.html#customlogger

const vueConfig = {
    template: {
        transformAssetUrls: {
            base: null,
            includeAbsolute: false,
        },
    },
};

import viteGlobalDefinitions from './resources/js/vite-global-definitions';

// https://vitejs.dev/config/
export default defineConfig(({ command, mode }) => {
    // https://vitejs.dev/config/#using-environment-variables-in-config
    // Load env file based on `mode` in the current working directory.
    // Set the third parameter to '' to load all env regardless of the `VITE_` prefix.
    const env = loadEnv(mode, process.cwd(), '');

    const viteConfig = {
        define: {
            __APP_ENV__: JSON.stringify(env.APP_ENV),
        },
        customLogger: logger, // https://vitejs.dev/config/shared-options.html#customlogger
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
            viteGlobalDefinitions({
                env,
            }),
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
            // rollupOptions: {
            //   // https://rollupjs.org/guide/en/#big-list-of-options
            // }
        },
    };

    return viteConfig;
})
