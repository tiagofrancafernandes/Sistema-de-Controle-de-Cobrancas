import * as r  from 'radash';
import { isAFunction, tryRun } from '@/Libs/Helpers/FunctionHelpers';
import {
    tryDate,
    asDate,
    formatDate,
} from '@/Libs/Helpers/DateHelpers';
import * as _DebounceThrottleHelpers from '@/Libs/Helpers/debounce-and-throttle';

export const _radash = r;
export const DebounceThrottleHelpers = _DebounceThrottleHelpers;

export const objectOnly = (value) => typeof value === 'object' && !Array.isArray(value) ? value : {};

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
