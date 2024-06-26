import SvgIcon from '@SvgIcons/Core/Components/SvgIcon.vue';
import { objectOnly } from '@/Libs/Helpers/DataHelpers';
import { loadAppComponents, loadAppMethods } from '@/Libs/Helpers/VueComponentHelpers';
import iconComponents from '@SvgIcons/.cache/icon-importer';
import SvgIconsData from '@resources/../svg-icons.json';

export const getSvgIconsData = (key = null, defaultValue = null) => {
    let data = objectOnly(SvgIconsData) || {};

    if (key === null) {
        return data;
    }

    key = typeof key === 'string' ? key.trim() : null;

    return key ? data[key] : defaultValue;
}

export const iconComponentsPrefix = () => {
    let componentPrefix = getSvgIconsData('config')?.prefix ?? 'svg-icon-';
    componentPrefix = typeof componentPrefix === 'string' ? componentPrefix.trim() : '';

    return `${componentPrefix}`.trim();
};

const SvgIconPlugin = (pluginOptions = {}) => {
    console.log('SvgIconsData', SvgIconsData, SvgIconsData?.config?.prefix);
    pluginOptions = objectOnly(pluginOptions) || {};

    return {
        install(app, options) {
            const methods = {
                //
            }

            app.component('SvgIcon', SvgIcon);

            loadAppMethods(methods, app, options);

            let _iconComponents = iconComponents;
            let componentPrefix = iconComponentsPrefix();

            if (componentPrefix) {
                _iconComponents = Object.fromEntries(
                    Object.entries(_iconComponents).map(item => [componentPrefix + item[0], item[1]])
                );
            }

            loadAppComponents(_iconComponents, app, options);
        },
    };
}

export default SvgIconPlugin;
