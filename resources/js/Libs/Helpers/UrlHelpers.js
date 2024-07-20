import { get, set } from 'radash';
import {
    isJson,
    tryJsonDecode,
    isArray,
    isNull,
    isNumeric,
    isObject,
    toNumeric,
    toBoolean,
    stringToBoolean,
    isString,
} from './TypeHelpers.js';

export function parseTypeFromValue(value, mapTypes = null) {
    let valueType = typeof(value);

    mapTypes = { // 'undefined' | 'empty' | 'null' | 'NaN'
        undefined: null,
        ...(isObject(mapTypes) ? mapTypes : {}),
    };

    switch(valueType) {
      case 'undefined':
        return mapTypes['undefined'] ?? null;
        break;

      case 'string':
        if (value.toLowerCase() === 'null') {
            return mapTypes['null'] ?? null;
        }

        if (value === '') {
            return mapTypes['empty'] ?? null;
        }

        if (isNumeric(value)) {
            return toNumeric(value);
        }

        if (stringToBoolean(value, null) !== null) {
            return stringToBoolean(value);
        }

        return tryJsonDecode(value, true);
        break;

      case 'number':
        if (isNaN(value)) {
            return mapTypes['NaN'] ?? null;
        }

        return toNumeric(value);
        break;

      case 'object':
            if (isNull(value)) {
                return mapTypes['null'] ?? null;
            }

            return value;
        break;

      case 'boolean':
        return toBoolean(value);
        break;

      default:
        console.log(`type ${valueType} not mapped`)
        return mapTypes[valueType] ?? value;
    }

    return value;
}

export function parseQueryString(queryString, parseType = false) {
    const params = new URLSearchParams(queryString);
    const result = {};

    for (const [key, value] of params.entries()) {
        const keys = key.match(/[^[\]]+/g);  // Matches all parts of the key
        let current = result;

        keys.forEach((k, i) => {
            if (i === keys.length - 1) {
                current[k] = parseType ? parseTypeFromValue(value) : value;
            } else {
                current[k] = current[k] || {};
                current = current[k];
            }
        });
    }

    return result;
}

export const currentUrlQuery = (key = null, defaultValue = null, parseType = false) => {
    if (!isNull(key) && !(isString(key) || isArray(key))) {
        return defaultValue;
    }

    const queryString = parseQueryString(location.search, parseType);

    if (isNull(key)) {
        return queryString;
    }

    key = isArray(key) ? key.join('.') : key;

    return get(queryString, key, defaultValue);
}

export const useUrlQuery = () => {
    return {
        current() {
            return {
                get query() {
                    return this.get(null, null, false);
                },
                get(key = null, defaultValue = null, parseType = false) {
                    return currentUrlQuery(key, defaultValue, parseType);
                },
                has(key) {
                    if (!(isString(key) || isArray(key))) {
                        return false;
                    }

                    key = isArray(key) ? key.join('.') : key;

                    let noVal = 'NO::ONE';
                    return get(this.query, key, noVal) !== noVal;
                },
                only(...keys) {
                    keys = keys
                        .filter(key => (isString(key) || isArray(key)))
                        .map(key => isArray(key) ? key.join('.') : key);

                    if (!keys || !keys.length) {
                        return {};
                    }

                    let query = this.query;
                    let result = {};
                    let noVal = 'NO::ONE';

                    for (let key of keys) {
                        let value = get(query, key, noVal);

                        if (value !== noVal) {
                            result = set(result, key, value);
                        }
                    }

                    return result;
                }
            }
        },
    }
};


export const queryStringPlainEntries = function(queryString = null) {
    queryString = decodeURI(queryString ?? location.search);
    queryString = isString(queryString) ? queryString : `${queryString}`;
    let regex = /[?&]([^=#]+)=([^&#]*)/g;
    let params = {};
    let match;

    while (match = regex.exec(queryString)) {
        params[match[1]] = match[2];
    }

    return params;
};
