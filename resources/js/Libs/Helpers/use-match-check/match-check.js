/**
 * ### To usage, read the README.md ###
 * Author: Tiago França <https://github.com/tiagofrancafernandes/>
 * Date: 2024-07-12
 */

export const useMatchCheck = (options, defaultValue = null) => {
    let DEBUG = false;
    if (typeof options !== 'object') {
        return defaultValue;
    }

    let optionsIsArray = Array.isArray(options);

    let collection = optionsIsArray ? options : Object.entries(options);

    return (value, def = null) => {
        let itemIndex = collection.findIndex(item => {
            item = Array.isArray(item) ? item : [];
            let toCheck = item[0] || [];
            let ifCheck = item[1] || undefined;

            if (toCheck === undefined || ifCheck === undefined) {
                return false;
            }

            toCheck = Array.isArray(toCheck) ? toCheck : [toCheck];

            return toCheck.includes(optionsIsArray ? value : `${value}`);
        });

        if (itemIndex === -1) {
            return def ?? defaultValue;
        }

        let result = (collection[itemIndex] ?? [])[1] ?? null;


        DEBUG && console.log('[DEBUG]', {collection, itemIndex, result});

        return result ?? def ?? defaultValue;
    };
}

export default useMatchCheck;
