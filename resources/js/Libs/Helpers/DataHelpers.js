import * as r  from 'radash';
import { isAFunction, tryRun } from '@/Libs/Helpers/FunctionHelpers';
import {
    tryDate,
    asDate,
    formatDate,
} from '@/Libs/Helpers/DateHelpers';

export const _radash = r;

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
