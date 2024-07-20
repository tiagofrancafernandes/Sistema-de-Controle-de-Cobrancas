import * as r  from 'radash';
import { isAFunction, tryRun } from '@/Libs/Helpers/FunctionHelpers';
import {
    tryDate,
    asDate,
    formatDate,
} from '@/Libs/Helpers/DateHelpers';
import * as _DebounceThrottleHelpers from '@/Libs/Helpers/debounce-and-throttle';
import {
    // isJson,
    // tryJsonDecode,
    isArray,
    // isNull,
    isNumeric,
    // isObject,
    // toNumeric,
    // toBoolean,
    // stringToBoolean,
    isString,
} from './TypeHelpers.js';

export const _radash = r;
export const DebounceThrottleHelpers = _DebounceThrottleHelpers;

export const objectOnly = (value) => typeof value === 'object' && !Array.isArray(value) ? value : {};
export const arrayOnly = (value) => Array.isArray(value) ? value : [];
export const objectOnlyOr = (value, defaultValue = {}) => typeof value === 'object'
    && !Array.isArray(value) ? value : objectOnly(defaultValue);
export const arrayOnlyOr = (value, defaultValue = []) => Array.isArray(value) ? value : arrayOnly(defaultValue);

export const objectGetOnly = (object, keys) => {
    keys = arrayOnly(keys);
    object = typeof object === 'object' ? object : {};
    return Object.fromEntries(Object.entries(object).filter(item => keys.includes(item[0])));
}

export const objectGetExcept = (object, keys) => {
    keys = arrayOnly(keys);
    object = typeof object === 'object' ? object : {};
    return Object.fromEntries(Object.entries(object).filter(item => !keys.includes(item[0])));
}

export const filled = (value) => {
    let valueType = typeof value;

    if (valueType === 'object') {
        return Boolean(Object.keys(value || {}).length);
    }

    if (valueType === 'string') {
        return Boolean(value.trim().length);
    }

    if (valueType === 'number') {
        return isNaN(value - 0) ? false : true;
    }

    if (valueType === 'undefined' || value === undefined || value === null || isNaN(value)) {
        return false;
    }

    return true;
}

/**
 * Usage:
 * `objectFilter({...}, item => item)`
 */
export const objectFilter = function(object, filter) {
    filter = typeof filter === 'function' ? filter : (value, key) => value;
    object = typeof object === 'object' ? object : {};

    return Object.fromEntries(Object.entries(object).filter(item => {
        let [key, value] = item;
        return filter(value, key);
    }));
}

/**
 * Usage:
 * `objectMap({a: { value: 123, }}, (item, key) => { return { valor: item.value}; })`
 * `objectMap({a: { value: 123, }}, (item, key) => { return { ...item, valor: item.value, key}; })`
 */
export const objectMap = function(object, mapFn) {
    mapFn = typeof mapFn === 'function' ? mapFn : (item, key) => item;

    return Object.fromEntries(Object.entries(object).map(item => {
        let [key, value] = item;
        value = mapFn(value, key);
        return [key, value];
    }));
}

export const count = (value) => {
    let valueType = typeof value;

    try {
        if (valueType === 'object') {
            return Object.keys(value || {}).length;
        }

        if (valueType === 'string') {
            return String(value).length;
        }

        return Object.keys(value || {}).length;
    } catch (error) {
        console.error(error);
        return 0;
    }
}

export const sizeCompare = (value, operator, toCompare = null) => {
    if (toCompare === null && !isNaN(operator -0)) {
        toCompare = (operator -0);
        operator = '==';
    }

    operator = typeof operator === 'string' ? operator.trim().toLowerCase() : null;

    toCompare = !isNaN(toCompare - 0) ? (toCompare - 0) : null;

    if (operator === null || toCompare === null) {
        return false;
    }

    let valueLength = !isNaN(value -0) ? (value -0) : count(value);

    switch (operator) {
        case '<':
        case 'lt':

        return valueLength < toCompare;
        break;

        case '<=':
        case 'le':

        return valueLength <= toCompare;
        break;

        case '=':
        case '==':
        case 'eq':

        return valueLength == toCompare;
        break;

        case '>':
        case 'gt':

        return valueLength > toCompare;
        break;

        case '>=':
        case 'ge':

        return valueLength >= toCompare;
        break;

        case '!=':
        case '<>':
        case 'ne':

        return valueLength != toCompare;
        break;

        default:
            return false;
            break;
    }

    return false;
}

export const lengthCompare = {
    from(value = 0) {
        return {
            value,
            lt(toCompare) {
                return lengthCompare.lt(this.value, toCompare)
            },
            le(toCompare) {
                return lengthCompare.le(this.value, toCompare)
            },
            eq(toCompare) {
                return lengthCompare.eq(this.value, toCompare)
            },
            gt(toCompare) {
                return lengthCompare.gt(this.value, toCompare)
            },
            ge(toCompare) {
                return lengthCompare.ge(this.value, toCompare)
            },
            ne(toCompare) {
                return lengthCompare.ne(this.value, toCompare)
            },
            compare(operator, toCompare = null) {
                return lengthCompare.compare(this.value, operator, toCompare = null)
            },
        }
    },
    lt(value, toCompare) {
        return sizeCompare(value, 'lt', toCompare);
    },
    le(value, toCompare) {
        return sizeCompare(value, 'le', toCompare);
    },
    eq(value, toCompare) {
        return sizeCompare(value, 'eq', toCompare);
    },
    gt(value, toCompare) {
        return sizeCompare(value, 'gt', toCompare);
    },
    ge(value, toCompare) {
        return sizeCompare(value, 'ge', toCompare);
    },
    ne(value, toCompare) {
        return sizeCompare(value, 'ne', toCompare);
    },
    compare(value, operator, toCompare = null) {
        return sizeCompare(value, operator, toCompare);
    },
}

export const dataGet = (data, key = null, defaultValue = null) => {
    data = typeof data === 'object' ? data : {};

    if (key === null) {
        return data;
    }

    key = ['string', 'number'].includes(typeof key) || Array.isArray(key) ? key : null;

    if (key === null) {
        return defaultValue;
    }

    return r.get(data, (Array.isArray(key) ? key.join('.') : key), defaultValue);
}

export const objectOnlyGet = (data, key = null, defaultValue = null) => {
    return dataGet(objectOnly(data) || {}, key, defaultValue);
}

export const arrayOnlyGet = (data, key = null, defaultValue = null) => {
    data = Array.isArray(data) ? data : [];

    return dataGet(data, key, defaultValue);
}

export const _get = (data, key = null, defaultValue = null) => {
    return dataGet(data, key, defaultValue);
}

export const _getMany = (data, ...keys) => {
    data = typeof data === 'object' ? (data || {}) : {};
    keys = keys
        .filter(key => (isString(key) || isArray(key)))
        .map(key => isArray(key) ? key.join('.') : key);

    let result = isArray(data) ? [] : {};
    let noVal = 'NO::ONE';

    for (let key of keys) {
        let value = dataGet(data, key, noVal);

        if (value !== noVal) {
            result = r.set(result, key, value);
        }
    }

    return result;
}

export const _getManyFromArrays = (data, ...keys) => {
    data = isArray(data) ? data : [];

    let result = [];

    for (let index in data) {
        result[index] = _getMany(data[index], ...keys);
    }

    return result;
}

export const _pluck = (data, ...keys) => _getManyFromArrays(data, ...keys);

export const dataHas = (data, key) => {
    data = typeof data === 'object' ? (data || {}) : {};
    key = isString(key) || isNumeric(key) ? `${key}` : '';

    return (isArray(data) ? data : Object.keys(data || {})).includes(key);
}

export const dataHasAny = (data, ...keys) => {
    keys = _arrayFlatern(keys);

    for (let key of keys) {
        if (dataHas(data, key)) {
            return true;
        }
    }

    return false;
}

export const dataHasAll = (data, ...keys) => {
    keys = _arrayFlatern(keys);
    data = typeof data === 'object' ? (data || {}) : {};

    if (!count(data)) {
        return false;
    }

    for (let key of keys) {
        if (!dataHas(data, key)) {
            return false;
        }
    }

    return true;
}

export const dataHasMany = (data, ...keys) => dataHasAll(data, ...keys);

export const getAsDate = (data, key, format = 'Date') => {
    if (key === null || key === undefined) {
        return null;
    }

    format = typeof format === 'string' ? format : null;

    let value = dataGet(data, key);

    try {
        value = ['object', 'string', 'number'].includes(typeof value) ? value : null;

        if (value === null) {
            return null;
        }

        return formatDate(value, format);
    } catch (error) {
        return null;
    }
}

export const getAsDateTime = (data, key, format = null) => {
    return getAsDate(data, key, format ?? 'datetime');
}

export const objectsAdvancedMerge = (items, config = {}) => {
    config = objectOnly(config);
    config['replace'] = Boolean(_get(config, 'replace', false));
    let mergeUsing = _get(config, 'mergeUsing');

    items = Array.isArray(items) ? items : [];
    items = items.filter(item => typeof item === 'object' && !Array.isArray(item))
        .map(item => {
            return Object.fromEntries(Object.entries(item).filter(_item => {
                let [key, value] = _item;

                return value !== undefined ? [key, value] : false;
            }))
        });

    let newObject = {};

    mergeUsing = typeof mergeUsing === 'function' ? mergeUsing : (_item, _newObject, _config) => {
        _item = objectOnly(_item);
        _newObject = objectOnly(_newObject);
        _config = objectOnly(_config);

        return (_config['replace']) ? ({
            ..._newObject,
            ..._item,
        }) : ({
            ..._item,
            ..._newObject,
        });
    }

    for (let item of items) {
        newObject = objectOnly(mergeUsing(item, newObject, config));
    }

    return newObject;
}

export const mergeObjects = (...items) => {
    return objectsAdvancedMerge(items, {
        replace: false,
    });
}

export const _arrayFlatern = (data) => {
    data = isArray(data) ? data : [];
    let result = [];
    data.map(item => result = [...result, ...Object.values(item)]);

    return result || [];
}

export const _flatern = (data) => _arrayFlatern(data);

export const DataValidatorHelpers = {
    numericOnly(value) {
        value = isString(value) || isNumeric(value) ? `${value}` : '';
        return value.replace(/\D/g, '');
    },
}
