const objectOr = (value, defaultValue = {}) => {
    typeof defaultValue === 'object' && !Array.isArray(defaultValue) ? defaultValue : {};

    return typeof value === 'object' && !Array.isArray(value) ? value : defaultValue;
}

const functions = {
    log: (...args) => console.log(...args), // Will be __log
    objectOr, // Will be __objectOr
    toStr: (...args) => JSON.stringify(...args),
    toObject: (value) => {
        try {
            return JSON.parse(JSON.stringify(value));
        } catch (error) {
            return {};
        }
    },
}

function viteGlobalDefinitions(options = {}) {
    options = objectOr(options);

    const env = objectOr(options?.env || null);

    const definitionsPrefix = '__';
    const strDefinitions = {};

    console.log(`\n`);
    for (let [itemName, item] of Object.entries(functions)) {
        itemName = `${definitionsPrefix}${itemName}`;
        console.log(itemName, item);
        strDefinitions[itemName] = `${item}`;
    }
    console.log(`\n`);

    return {
        name: "vite:vite-global-definitions-plugin",
        config(config = {}) {
            return {
                define: {
                    // __DEMO_PL1__: config?.define?.__DEMO_PL1__ ?? JSON.stringify('__DEMO_PL1__'),
                    __APP_NAME: config?.define?.__APP_NAME ?? JSON.stringify(env.APP_ENV),
                    ...(strDefinitions),
                }
            };
        },
    };
}

export default viteGlobalDefinitions;
