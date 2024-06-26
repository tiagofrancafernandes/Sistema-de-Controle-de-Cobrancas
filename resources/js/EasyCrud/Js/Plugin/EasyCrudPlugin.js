import { objectOnly } from '@/Libs/Helpers/DataHelpers';
import { loadAppComponents, loadAppMethods } from '@/Libs/Helpers/VueComponentHelpers';
import crudComponents from '@EasyCrud/crud-components'

const EasyCrudPlugin = (pluginOptions = {}) => {
    pluginOptions = objectOnly(pluginOptions) || {};

    return {
        install(app, options) {
            const methods = {
                //
            }

            loadAppMethods(methods, app, options);

            loadAppComponents(objectOnly(crudComponents), app, options);
        },
    };
}

export default EasyCrudPlugin;
