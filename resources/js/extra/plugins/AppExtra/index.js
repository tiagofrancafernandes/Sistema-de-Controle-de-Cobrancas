import { randomString } from '@/Libs/Helpers/StringHelpers';

const toJson = function (...params) {
    return JSON.stringify(...params);
};

const AppExtra = {
    install(app, options) {
        const methods = {
            toJson,
        }

        app.mixin({
            methods: methods,
        });

        if (parseInt(app.version) > 2) {
            Object.entries(methods).forEach(item => {
                let [name, func] = item;

                app.provide(name, func);
            })
        }

        // Global function
        app.config.globalProperties.$toJson = toJson;
        app.config.globalProperties.$randomStr = randomString;
        app.config.globalProperties.$genId = (prefix) => randomString(15, prefix);
        if (!('$id' in app.config.globalProperties)) {
            app.config.globalProperties.$id = (prefix = 'id') => randomString(15, prefix);
        }

        // Global directive
        app.directive('extra-data', {
            beforeMount(el, binding, vnode, prevVnode) {
                // el.textContent = binding.value;
                el.setAttribute('data-extra', JSON.stringify(binding.value));
            },
            updated(el, binding, vnode, prevVnode) {
                el.setAttribute('data-extra', JSON.stringify(binding.value));
                // el.textContent = binding.value;
            },
        });
    },
};

export default AppExtra;
