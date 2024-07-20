export const toBool = (value) => {
    if (!isNaN(parseFloat(value))) {
        return Boolean(parseFloat(value));
    }

    if (!value) {
        return Boolean(value);
    }

    let type = typeof value;

    type = `${type}`.toLowerCase();

    if (type === 'boolean') {
        return value;
    }

    let values = {
        'no': false,
        'nao': false,
        'false': false,
        'f': false,
        'não': false,
        'n': false,
        '0': false,
        0: false,

        'yes': true,
        'sim': true,
        'true': true,
        't': true,
        's': true,
        '1': true,
        1: true,
    };

    if (type in values || value in values) {
        return values[type];
    }

    return Boolean(value);
}

export const toIntOr = (value, defaultValue = null) => {
    value = parseInt(value);
    defaultValue = defaultValue !== null && !isNaN(parseInt(defaultValue)) ? parseInt(defaultValue) : null;

    return !isNaN(value) ? value : defaultValue;
}

export const toPositiveIntOr = (value, defaultValue = 0) => {
    defaultValue = toIntOr(defaultValue, 0);
    value = toIntOr(value, defaultValue) || defaultValue;

    return value > 0 ? value : (value - (value * 2));
}

export const positiveIntOr = (value, defaultValue = 0) => {
    return toPositiveIntOr(value, defaultValue);
}

export const msTimeFromExpression = (value) => {
    if ((typeof value === 'number') && !isNaN(parseInt(value))) {
        return parseInt(value);
    }

    if (typeof value !== 'string') {
        return null;
    }

    let isNegative = value.startsWith('-') || value < 0;

    value = isNegative ? value.slice(1) : value;

    let result = value.match(/^([0-9]){1,}(ms|s|m|h){1}$/g);

    if (!result) {
        result = !isNaN(parseInt(value)) ? parseInt(value) : null;
        return isNegative ? result - (result * 2) : result;
    }

    value = (result ?? [null])[0] ?? null;

    let num = parseInt(value.slice(0, value.search(/(.?)(ms|s|m|h){1}$/g) + 1));
    let timeXpr = value.slice(value.search(/(.?)(ms|s|m|h){1}$/g) + 1);

    if (isNaN(num)) {
        return null;
    }

    const getValueFor = (time, xpr) => {
        switch (xpr) {
        case 's':
            return time * 1000;
            break;

        case 'm':
            return (time * 1000) * 60;
            break;

        case 'h':
            return (time * 1000) * (60 * 60);
            break;

        case 'ms':
        default:
            return time;
        }
    };

    result = getValueFor(num, timeXpr);
    return isNegative ? result - (result * 2) : result;
}

export const positiveMsTimeFromExpression = (value) => {
    let result = toIntOr(msTimeFromExpression(value), 0);
    return toPositiveIntOr(result, (result - (result * 2)));
}

export const isString = (value) => {
    return typeof value === 'string';
}

export const isJson = (value) => {
    try {
        if (typeof value !== 'string') {
            return false;
        }

        JSON.parse(value);

        return true
    } catch(error) {
        return false;
    }
}

export const tryJsonDecode = (value, returnValueOnFail = false) => {
    try {
        return isJson(value) ? JSON.parse(value) : (returnValueOnFail ? value :  null);
    } catch(error) {
        return (returnValueOnFail ? value :  null);
    }
};
export const isArray = (val) => Array.isArray(val);
export const isNull = (val) => val === null;
export const isNumeric = (val) => !isNaN(val -0);
export const isObject = (val) => val && (typeof val) === 'object' && !Array.isArray(val);
export const toNumeric = (val, defaultValue = null) => isNumeric(val) ? (val -0) : toNumeric(defaultValue, null);

export function toBoolean (value, defaultFalse = false) {
    let valueType = typeof(value);

    if (['string', 'boolean', 'number'].includes(valueType)) {
        return stringToBoolean(value, defaultFalse);
    }

    if (['object'].includes(valueType)) {
        return Boolean(Object.keys(null || {}).length);
    }

    return Boolean(Object.keys(value || {}).length);
}

export function stringToBoolean (value, defaultFalse = false) {
    let valueType = typeof(value);
    const booleans = {
        'true': true,
        'yes': true,
        '1': true,
        'false': false,
        'no': false,
        '0': false,
        'null': false,
        'undefined': false,
    };

    value = ['string', 'boolean'].includes(valueType) ? (`${value}`)?.toLowerCase()?.trim() : false;

    if (value in booleans) {
        return booleans[value];
    }

    if (defaultFalse === null) {
        return null;
    }

    return Boolean(defaultFalse);
}
