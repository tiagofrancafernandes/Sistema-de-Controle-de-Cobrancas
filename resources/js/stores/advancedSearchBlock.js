import { ref } from 'vue'
import { defineStore } from 'pinia'
import { useStorage } from '@vueuse/core';
import { get, set } from "radash";

const strOr = (value, defaultValue = null) => typeof value === 'string' ? value : defaultValue;
const objectOr = (value, defaultValue = null) => typeof value === 'object' && !Array.isArray(value) ? value : defaultValue;
const genKey = (key) => {
    key = Array.isArray(key) ? key.join('.') : `${key}`;
    return key.split(',').join('.');
}
const formatPageId = (pageId) => strOr(pageId, '').replaceAll(/(\.|_)/ig, '_');

const _get = (object, key, defaultValue = null) => {
    return get(object, genKey(key), defaultValue);
}

const _set = (object, key, value) => {
    object = objectOr(object, {});
    object = set(object, genKey(key), value);

    return object;
}

export const customAdvancedSearchStore = (options = {}) => {
    options = objectOr(options, {});
    let storeUid = strOr(options?.id || options?.uid, '')?.trim();
    let DEBUG = Boolean(options?.debug || options?.DEBUG || false);
    let initialShow = Boolean(options?.id ?? false);
    let pageId = formatPageId(storeUid ? `${storeUid}` : 'default');

    return defineStore('advancedSearch', () => {
        let initialValue = {
            pages: {
                default: {
                    show: false,
                },
            },
        };

        _set(initialValue, ['pages', pageId, 'show'], initialShow);

        const advancedSearch = useStorage('advancedSearch', ref(initialValue));

        const setData = (key, data) => {
            const _advancedSearch = { ...advancedSearch.value };
            _set(_advancedSearch, key, data);
            _set(_advancedSearch, 'updated_at', (new Date()).toISOString());
            advancedSearch.value = _advancedSearch;
        }

        function all() {
            return JSON.parse(JSON.stringify((advancedSearch.value || {})))
        }

        function setValue(key, value, toPage = null) {
            toPage = strOr(toPage);

            DEBUG && console.log('[DEBUG]', 'setValue', {key, value, toPage});
            let keyToSet = genKey(toPage ? ['pages', toPage, key] : [key]);
            setData(keyToSet, value);
        }

        function toggleAdvancedSearch(toPage = null) {
            pageId = formatPageId(toPage ?? pageId ?? storeUid, storeUid);

            DEBUG && console.log('[DEBUG]', 'toggleAdvancedSearch pageId:', pageId);

            let newValue = !_get(all(), ['pages', pageId, 'show'], false);
            setData(['pages', pageId, 'show'], newValue, toPage);
        }

        function only(pageId) {
            pageId = formatPageId(strOr(pageId, storeUid)?.trim());
            return _get(all(), ['pages', pageId]);
        }

        return {
            get advancedSearch() {
                return only(this.pageId);
            },
            get pageId() {
                return formatPageId(pageId);
            },
            get key() {
                return this.pageId;
            },
            get uid() {
                return storeUid;
            },
            get DEBUG() {
                return DEBUG;
            },
            get(key = null, defaultValue = null) {
                return _get(all(), key, defaultValue);
            },
            set(key = null, value) {
                return setValue(key, value);
            },
            get show() {
                return this.get(['pages', this.pageId, 'show']);
            },
            toggleShow() {
                this.set(['pages', this.pageId, 'show'], !this.show);
                return;
            },
            __advancedSearch: advancedSearch,
            toggleAdvancedSearch,
            all,
            only,
            setValue,
        };
    });
}

export const useAdvancedSearchStore = customAdvancedSearchStore();

export const useAdvancedFilters = defineStore('advancedFilters', () => {
    const showAdvancedFilters = useStorage('advancedFilters', ref(false));

    function toggleShow() {
        console.log('toggleShow 1', showAdvancedFilters.value);
        showAdvancedFilters.value = !showAdvancedFilters.value;
        console.log('toggleShow 2', showAdvancedFilters.value);
    }

    return { showAdvancedFilters, toggleShow }
})
