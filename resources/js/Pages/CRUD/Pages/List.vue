<script setup lang="ts">
import { router } from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import * as DataHelpers from '@/Libs/Helpers/DataHelpers';
import { dataGet, objectOnly, mergeObjects } from '@/Libs/Helpers/DataHelpers';
import { validClassMerge } from '@/Libs/Helpers/CssHelpers';
import TableOne from '@/Components/Tables/TableOne.vue'
import TableTwo from '@/Components/Tables/TableTwo.vue'
import TableThree from '@/Components/Tables/TableThree.vue'
import CustomTable from '@/Components/Tables/CustomTable.vue'
// import TailAdminLayout from '@/Layouts/TailAdminLayout.vue'
import TailAdminLayout from '@/Layouts/TailAdminLayout.vue';
// import OpenedEyeIcon from '@/Components/Icons/OpenedEyeIcon.vue';

import { debounce } from '@/Libs/Helpers/debounce-and-throttle';

const emit = defineEmits(['update:checked']);

const pageProps = defineProps({
    pageTitle: {
        type: String,
    },
    pageData: {
        type: Object,
        required: true,
    },
    // checked: {
    //     type: [Array, Boolean],
    //     required: true,
    // },
});

const pageTitle = computed(() => pageProps?.pageTitle ?? 'CRUD Table');
const pageSubtitle = computed(() => 'Table');
const pageConfig = computed(() => {
    let pageData = objectOnly(pageProps?.pageData);
    return {
        pageData: {
            ...({
                table: {
                    columns: [],
                },
                records: [],
            }),
            ...(pageData),
        },
    }
});

const pageData = computed(() => {
    return pageConfig.value?.pageData;
});


const breadcrumbItems = [
    {
        label: pageTitle.value,
        href: '/profile',
    },
    {
        label: pageSubtitle.value,
    }
];

const genHeaderRow = (rowData) => {
    rowData = DataHelpers.objectOnly(rowData) || {};

    return {
        ...{
            key: 'id',
            label: 'ID',
            content: null,
            attributes: {
                attr1: 'val1',
                attr2: 'val2',
            },
            classes: [],
            headerComponent: null,
            dataComponent: null,
            sortable: false,
            sortableKey: 'id',
            show: true,
            type: 'content', // content|action|actionGroup|empty
        },
        ...rowData,
    };
}

const callables = {
    recordAttribute: {
        fn: (extra, params) => {
            let { record } = extra;
            let attribute = params[0] ?? null;
            attribute = typeof attribute === 'string' && attribute.trim() ? attribute.trim() : null;

            return attribute ? dataGet(record, attribute) : null;
        }
    },
    evalThis: {
        fn: (extra, params) => {
            try {
                let toEval = params[0] ?? null;
                toEval = typeof toEval === 'string' ? toEval : null;
                return toEval ? eval(toEval) : null;
            } catch(error) {
                return null;
            }
        }
    },
}

const getPropsDynamically = (dynamicProps, extra) => {
    let finalProps = {};

    try {
        dynamicProps = objectOnly(dynamicProps);
        extra = objectOnly(extra);

        for (let item of Object.entries(dynamicProps)) {
            let [propName, toCall] = item;
            if ((typeof propName !== 'string') || !propName.trim()) {
                continue;
            }

            let {
                callable,
                params
            } = (toCall || {});

            params = Array.isArray(params) ? params : [];

            callable = typeof callable === 'string' && callable.trim() ? callable : null;

            if (callable && (callable in callables)) {
                callable = (callables[callable] ?? {})['fn'] ?? null;
            }

            callable = typeof callable === 'function' ? callable : null;

            finalProps = objectOnly(finalProps);

            finalProps[propName] = callable ? callable(extra, params) : null;
        }
    } catch (error) {
        return {};
    }

    return objectOnly(finalProps) ;
}

const makeDynamicPropCaller = (callable, ...params) => {
    callable = typeof callable === 'string' && callable.trim() ? callable.trim() : null;

    return {
        callable,
        params,
    };
}

// const pageData = ref({
//     table: {
//         columns: [
//             genHeaderRow({key: 'id', label: 'ID'}),
//             genHeaderRow({key: 'name', label: 'Package'}),
//             genHeaderRow({
//                 key: 'price', label: 'Price',
//                 dataComponent: 'CrudTBodyTD2Lines',
//                 props: {
//                     staticProps: {
//                         abc: 123,
//                         xyz: 465,
//                     },
//                     dynamicProps: {
//                         userId: {
//                             callable: 'recordAttribute',
//                             params: [ 'id' ],
//                         },
//                         date: {
//                             callable: 'evalThis',
//                             params: [ `(new Date('2024-01-28')).toLocaleString()` ],
//                         },
//                         now: makeDynamicPropCaller('evalThis', `(new Date()).toLocaleString()`),
//                         lineOne: makeDynamicPropCaller('recordAttribute', 'name'),
//                         lineTwo: makeDynamicPropCaller('recordAttribute', 'price'),
//                     },
//                 },
//             }),
//             genHeaderRow({key: 'invoiceDate', label: 'Invoice date'}),
//             genHeaderRow({key: 'status', label: 'Status', }),
//             genHeaderRow({key: 'actions', label: 'Actions', type: 'actionGroup'}),
//         ],
//     },
//     records: [
//         {id: 15, name: 'Free Package', price: '$0.00', invoiceDate: 'Jan 13, 2025', status: 'Paid'},
//         {id: 16, name: 'Standard Package', price: '$79.00', invoiceDate: 'Jan 13, 2025', status: 'Paid'},
//         {id: 17, name: 'Business Package', price: '$99.00', invoiceDate: 'Jan 13, 2025', status: 'Unpaid'},
//         {id: 18, name: 'Standard Package', price: '$59.00', invoiceDate: 'Jan 13, 2025', status: 'Pending'},
//     ],
// })

// console.log('pageData', JSON.stringify(pageData.value));
// console.log('pageConfig', JSON.stringify(pageConfig.value?.pageData));

// let icon = 'SvgIconOpenedEye';
let icon = 'heroicon-s-arrow-down-circle';

const tableColumns = computed(() => dataGet(pageData.value, 'table.columns'));
const records = computed(() => dataGet(pageData.value, 'records'));

const theadConfig = computed(() => objectOnly(dataGet(pageData.value, 'table.theadConfig')));
const tbodyConfig = computed(() => objectOnly(dataGet(pageData.value, 'table.tbodyConfig')));
const tfootConfig = computed(() => objectOnly(dataGet(pageData.value, 'table.tfootConfig')));
const theadRowClasses = computed(() => dataGet(theadConfig.value, 'rowClasses'));
const tbodyRowClasses = computed(() => dataGet(tbodyConfig.value, 'rowClasses'));
const tfootRowClasses = computed(() => dataGet(tfootConfig.value, 'rowClasses'));

const theadColClasses = computed(() => dataGet(theadConfig.value, 'colClasses'));
const tbodyColClasses = computed(() => dataGet(tbodyConfig.value, 'colClasses'));
const tfootColClasses = computed(() => dataGet(tfootConfig.value, 'colClasses'));

const recordContent = (record, columnData, defaultValue = null) => {
    record = typeof record === 'object' ? record : null;
    columnData = typeof columnData === 'object' ? columnData : null;

    if (!columnData || !record) {
        return defaultValue;
    }

    let columnContent = dataGet(columnData, 'content');

    if (columnContent && typeof columnContent === 'function') {
        return columnContent(record, columnData);
    }

    let columnKey = dataGet(columnData, 'key');

    if (!columnKey) {
        return defaultValue;
    }

    return dataGet(record, columnKey, defaultValue);
};

const getColumnProps = (record, columnData) => {
    record = objectOnly(record);
    columnData = objectOnly(columnData);
    const colProps = dataGet(columnData, 'props', {});
    let { staticProps, dynamicProps } = objectOnly(colProps);

    let propsDynamically = getPropsDynamically(dynamicProps, {
        record,
        columnData,
    }) ?? {};

    return {
        ...(objectOnly(staticProps)),
        ...(objectOnly(propsDynamically)),
    };
}

const getPropsAndAttributes = (record, columnData, valuesToMerge = {}) => {
    record = objectOnly(record);
    columnData = objectOnly(columnData);
    valuesToMerge = objectOnly(valuesToMerge);

    if (!columnData || !record) {
        return valuesToMerge;
    }

    let classesToMerge = dataGet(valuesToMerge, 'class');
    let columnProps = getColumnProps(record, columnData);
    let columnAttributes = objectOnly(dataGet(columnData, 'attributes', valuesToMerge));
    let recordKey = dataGet(columnData, 'key');

    if (columnProps && typeof columnProps === 'function') {
        columnProps = objectOnly(columnProps(record, columnData));
    }

    let merged = mergeObjects(
        valuesToMerge,
        columnAttributes,
        columnProps,
    );

    let allClasses = [
        dataGet(valuesToMerge, 'class'),
        dataGet(columnAttributes, 'class'),
        dataGet(merged, 'class'),
    ];

    merged['class'] = validClassMerge(...allClasses);

    if (!Object.keys(merged['class']).length) {
        delete merged['class'];
    }

    let contentAttrs = ['label', 'html', 'content'];
    let currentContent = null;

    for (let contentAttr of contentAttrs) {
        currentContent = currentContent ?? ((contentAttr in merged) ? merged[contentAttr] : null);

    }

    if (currentContent === null) {
        currentContent = recordKey !== null ? dataGet(record, recordKey) : null;

        merged['content'] = merged['content'] || currentContent;
        merged['label'] = merged['label'] || currentContent;
        merged['html'] = merged['html'] || currentContent;
    }

    return merged;
};

const getSearchParams = (key = null, defaultValue = null) => {
    let searchParams = new URLSearchParams(location.search);

    if (key === null) {
        return searchParams;
    }

    key = typeof key === 'string' ? key : null;

    if (key === null) {
        return defaultValue;
    }

    return searchParams.get(key) ?? defaultValue;
}

let search = ref(getSearchParams('search'));

const onChangeSearch = debounce((event) => {
    console.log('changed value:', event?.target?.value, {event});
    // call fetch API to get results

    let searchValue = search.value;
    let urlQuery = searchValue ? `?search=${search.value}` : '';
    let url = `/dev/crud/index/v2${urlQuery}`;

    router.visit(url, {
        only: ['pageData'],
        // except: ['pageData'],
    });
}, 500);
</script>

<template>
    <TailAdminLayout
        :pageTitle="pageTitle"
        :breadcrumbItems="breadcrumbItems"
    >
    <div class="w-full my-4">
        <!-- <Link href="/users?active=true" :only="['users']">Show active</Link> -->
        <Link href="/dev/crud/index/v2?search=beer" :only="['pageData']">Show search result</Link>

        <div class="py-2">
            <div :class="{'p-1': search, 'p-4': !search}">{{ search }}</div>
            <input
                type="search"
                :placeholder="'Search'"
                v-model.trim="search"
                v-on:keyup="onChangeSearch"
            >
        </div>
    </div>

    <div class="flex flex-col gap-10">
        <div
            class="rounded-lg border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark"
        >
            <div class="rounded-lg max-w-full overflow-x-auto">
                <table class="w-full table-auto">
                    <thead>
                        <tr class="bg-gray-2 text-left dark:bg-meta-4">
                            <template
                                v-for="(headerItem, headerItemIndex) in tableColumns"
                                :key="headerItem?.key ?? headerItemIndex"
                            >
                                <!-- headerItem.classes -->
                                <!-- headerItem.headerComponent -->
                                <!-- headerItem.sortable -->
                                <!-- headerItem.sortableKey -->
                                <!-- headerItem.show -->
                                <template v-if="dataGet(headerItem, 'headerComponent')">
                                    <component
                                        :is="dataGet(headerItem, 'headerComponent')"
                                        v-bind="dataGet(headerItem, 'attributes')"
                                        v-show="dataGet(headerItem, 'show', true)"
                                        :class="validClassMerge(
                                            ['py-4 px-4 font-medium text-black dark:text-white'],
                                            dataGet(headerItem, 'classes'),
                                        )"
                                        v-bind:sortable-component="dataGet(headerItem, 'sortable')"
                                        v-bind:data-sortable-key="dataGet(headerItem, 'sortableKey')"
                                        v-html="dataGet(headerItem, 'content') ?? dataGet(headerItem, 'label')"
                                    ></component>
                                </template>
                                <template v-else>
                                    <th
                                        v-show="dataGet(headerItem, 'show', true)"
                                        :class="validClassMerge(
                                            ['py-4 px-4 font-medium text-black dark:text-white'],
                                            dataGet(headerItem, 'classes'),
                                        )"
                                        v-bind:sortable-component="dataGet(headerItem, 'sortable')"
                                        v-bind:data-sortable-key="dataGet(headerItem, 'sortableKey')"
                                        v-html="dataGet(headerItem, 'content') ?? dataGet(headerItem, 'label')"
                                        v-bind="dataGet(headerItem, 'attributes')"
                                    ></th>
                                </template>
                            </template>
                            <!-- <th class="min-w-[220px] py-4 px-4 font-medium text-black dark:text-white xl:pl-11">Package</th>
                            <th class="min-w-[150px] py-4 px-4 font-medium text-black dark:text-white">Invoice date</th>
                            <th class="min-w-[120px] py-4 px-4 font-medium text-black dark:text-white">Status</th>
                            <th class="py-4 px-4 font-medium text-black dark:text-white">Actions</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="(item, index) in records" :key="index"
                            :class="validClassMerge(
                                ['border-t border-stroke dark:border-strokedark'],
                                tbodyRowClasses,
                            )"
                        >
                            <template
                                v-for="(col, colIndex) in tableColumns"
                                :key="colIndex"
                            >
                                <template v-if="dataGet(col, 'show')">
                                    <template v-if="dataGet(col, 'dataComponent')">
                                        <component
                                            v-show="dataGet(col, 'show', true)"
                                            :is="dataGet(col, 'dataComponent')"
                                            v-bind="getPropsAndAttributes(item, col, {
                                                abc: [123, 'pos1'],
                                                aaclass: validClassMerge(
                                                    ['py-4 px-4 font-medium text-black dark:text-white'],
                                                    dataGet(col, 'classes'),
                                                    tbodyColClasses,
                                                ),
                                            })"
                                        ></component>
                                    </template>
                                    <template v-else>
                                        <CrudTBodyTD
                                            v-show="dataGet(col, 'show', true)"
                                            v-bind="getPropsAndAttributes(item, col, {
                                                abc: [123, 'pos2'],
                                                class: validClassMerge(
                                                    dataGet(col, 'classes', {}),
                                                    tbodyColClasses,
                                                ),
                                            })"
                                        ></CrudTBodyTD>
                                    </template>
                                </template>
                            </template>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr class="bg-gray-2 text-left dark:bg-meta-4">
                            <td
                                colspan="100%"
                                aaclass="min-w-[220px] py-4 px-4 font-medium text-black dark:text-white xl:pl-11 text-right"
                            >
                                <div class="flex flex-col space-y-4 items-end justify-end py-3 pr-3">
                                    <nav>
                                        <ul class="flex items-center -space-x-px h-10 text-base">
                                            <li>
                                                <a href="#" class="flex items-center justify-center px-4 h-10 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                                    <span class="sr-only">Previous</span>
                                                    <svg class="w-3 h-3 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"></path>
                                                    </svg>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">1</a>
                                            </li>
                                            <li>
                                                <a href="#" class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">2</a>
                                            </li>
                                            <li>
                                                <a href="#" aria-current="page" class="z-10 flex items-center justify-center px-4 h-10 leading-tight text-blue-600 border border-blue-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">3</a>
                                            </li>
                                            <li>
                                                <a href="#" class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">4</a>
                                            </li>
                                            <li>
                                                <a href="#" class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">5</a>
                                            </li>
                                            <li>
                                                <a href="#" class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                                    <span class="sr-only">Next</span>
                                                    <svg class="w-3 h-3 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"></path>
                                                    </svg>
                                                </a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
  </TailAdminLayout>
</template>
