import { computed } from 'vue';
import { objectOnly } from '@/Libs/Helpers/DataHelpers';

export const useExtraAttributes = (props) => computed(() => {
    if (
        !props.extraAttributes
        || (typeof props.extraAttributes !== 'object')
        || Array.isArray(props.extraAttributes)
    ) {
        return {};
    }

    return props.extraAttributes;
});

export const loadAppComponents = function(componentList, app, options, ...args) {
    const objectOnly = (value) => typeof value === 'object' && !Array.isArray(value) ? value : {};
    componentList = objectOnly(componentList);
    app = objectOnly(app);
    options = objectOnly(options);

    if (parseInt(app?.version) > 2) {
        Object.entries(componentList).forEach(item => {
            let [name, component] = item;

            app.component(name, component);
        })
    }
}

export const loadAppMethods = function(methodsList, app, options, ...args) {
    methodsList = objectOnly(methodsList);
    app = objectOnly(app);
    options = objectOnly(options);

    app.mixin({
        methods: methodsList,
    });

    if (parseInt(app?.version) > 2) {
        Object.entries(methodsList).forEach(item => {
            let [name, method] = item;

            app.method(name, method);
        })
    }
}
