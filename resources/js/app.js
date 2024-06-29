import './bootstrap';
import '../css/app.css';
import './assets/css/satoshi.css'
import './assets/css/style.css'
import 'jsvectormap/dist/css/jsvectormap.min.css'
import 'flatpickr/dist/flatpickr.min.css'

import * as _ from 'radash';
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createPinia } from 'pinia'
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import { Link } from '@inertiajs/vue3';
import { sprintf } from 'sprintf-js';

// import VueApexCharts from 'vue3-apexcharts' //
// import AppExtra from '@/extra/plugins/AppExtra';
// import SvgIconPlugin from '@SvgIcons/Core/Js/SvgIconPlugin';
// import EasyCrudPlugin from '@EasyCrud/Js/Plugin/EasyCrudPlugin';
const VueApexCharts = () => import('vue3-apexcharts');
const AppExtra = () => import('@/extra/plugins/AppExtra');
const SvgIconPlugin = () => import('@SvgIcons/Core/Js/SvgIconPlugin');
const EasyCrudPlugin = () => import('@EasyCrud/Js/Plugin/EasyCrudPlugin');

import * as StringHelpers from '@/Libs/Helpers/StringHelpers';
import * as HtmlHelpers from '@/Libs/Helpers/HtmlHelpers';
import * as CssHelpers from '@/Libs/Helpers/CssHelpers';
import * as FunctionHelpers from '@/Libs/Helpers/FunctionHelpers';
import * as TWHelpers from '@/Libs/Helpers/TWHelpers';
import * as DataHelpers from '@/Libs/Helpers/DataHelpers';
import * as DateHelpers from '@/Libs/Helpers/DateHelpers';
// import OpenedEyeIcon from '@SvgIcons/Icons/OpenedEyeIcon.vue';
// import IconImporter from '@SvgIcons/.cache/icon-importer';

window.addEventListener('vite:preloadError', (event) => {
    /* https://vitejs.dev/guide/build#load-error-handling */
    // window.location.reload() // for example, refresh the page
    console.log(`Some data on 'vite:preloadError'`, {event});
})

globalThis._ = _;
globalThis.StringHelpers = StringHelpers;
globalThis.HtmlHelpers = HtmlHelpers;
globalThis.FunctionHelpers = FunctionHelpers;

const globalFunctions = {
    ...FunctionHelpers,
    sprintf,
    ...CssHelpers,
    ...StringHelpers,
    ...HtmlHelpers,
    ...TWHelpers,
    tw: TWHelpers,
    ...DataHelpers,
    ...DateHelpers,
};

FunctionHelpers.pushGlobalFunctions(globalFunctions, globalThis, false);

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(AppExtra)
            .use(SvgIconPlugin())
            .use(EasyCrudPlugin())
            .use(createPinia())
            .use(VueApexCharts)
            .use(ZiggyVue)
            .component('Link', Link)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
