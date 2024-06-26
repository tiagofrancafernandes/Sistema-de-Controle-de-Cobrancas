<script setup lang="ts">
import { ref, computed } from 'vue'
import * as DataHelpers from '@/Libs/Helpers/DataHelpers';
import { dataGet, objectOnly } from '@/Libs/Helpers/DataHelpers';
import { validClassMerge } from '@/Libs/Helpers/CssHelpers';
import TableOne from '@/Components/Tables/TableOne.vue'
import TableTwo from '@/Components/Tables/TableTwo.vue'
import TableThree from '@/Components/Tables/TableThree.vue'
import CustomTable from '@/Components/Tables/CustomTable.vue'
// import TailAdminLayout from '@/Layouts/TailAdminLayout.vue'
import TailAdminLayout from '@/Layouts/TailAdminLayout.vue';
// import OpenedEyeIcon from '@/Components/Icons/OpenedEyeIcon.vue';

const pageTitle = computed(() => 'CRUD Table');
const pageSubtitle = computed(() => 'Table');

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
            component: null,
            sortable: false,
            sortableKey: 'id',
            show: true,
            type: 'content', // content|action|actionGroup|empty
        },
        ...rowData
    };
}

const pageData = ref({
    table: {
        headers: {
            containerComponent: null,
            containerComponentAttrs: {},
            items: [
                genHeaderRow({key: 'id', label: 'ID'}),
                genHeaderRow({key: 'name', label: 'Package'}),
                genHeaderRow({key: 'price', label: 'Price'}),
                genHeaderRow({key: 'invoiceDate', label: 'Invoice date'}),
                genHeaderRow({key: 'status', label: 'Status', }),
                genHeaderRow({key: 'actions', label: 'Actions', type: 'actionGroup'}),
            ]
        },
    },
    records: [
        { component: null, id: 15, name: 'Free Package', price: '$0.00', invoiceDate: 'Jan 13, 2025', status: 'Paid' },
        { component: null, id: 16, name: 'Standard Package', price: '$79.00', invoiceDate: 'Jan 13, 2025', status: 'Paid' },
        { component: null, id: 17, name: 'Business Package', price: '$99.00', invoiceDate: 'Jan 13, 2025', status: 'Unpaid' },
        { component: null, id: 18, name: 'Standard Package', price: '$59.00', invoiceDate: 'Jan 13, 2025', status: 'Pending' }
    ],
})

// let icon = 'SvgIconOpenedEye';
let icon = 'heroicon-s-arrow-down-circle';

const tableHeaders = computed(() => dataGet(pageData.value, 'table.headers'));
const records = computed(() => dataGet(pageData.value, 'records'));
</script>

<template>
    <TailAdminLayout
        :pageTitle="pageTitle"
        :breadcrumbItems="breadcrumbItems"
    >
    <div class="flex flex-col gap-10">
        <div
            class="rounded-lg border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark"
        >
            <div class="rounded-lg max-w-full overflow-x-auto">
                <table class="w-full table-auto">
                    <thead>
                        <template v-if="tableHeaders?.containerComponent">
                            <component
                                :is="tableHeaders?.containerComponent"
                                v-bind="tableHeaders?.containerComponentAttrs"
                                :items="tableHeaders?.items"
                            ></component>
                        </template>
                        <template v-else>
                            <tr class="bg-gray-2 text-left dark:bg-meta-4">
                                <template
                                    v-for="(headerItem, headerItemIndex) in tableHeaders?.items"
                                    :key="headerItem?.key ?? headerItemIndex"
                                >
                                    <!-- headerItem.classes -->
                                    <!-- headerItem.component -->
                                    <!-- headerItem.sortable -->
                                    <!-- headerItem.sortableKey -->
                                    <!-- headerItem.show -->
                                    <template v-if="dataGet(headerItem, 'component')">
                                        <component
                                            :is="dataGet(headerItem, 'component')"
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
                        </template>
                    </thead>
                    <tbody>
                        <tr
                            v-for="(item, index) in records" :key="index"
                            class="border-t border-stroke dark:border-strokedark"
                        >
                            <CrudTBodyTD2Lines
                                :lineOne="item.name"
                                :lineTwo="item.price"
                            />
                            <CrudTBodyTD><!-- {{ item.invoiceDate }} -->{{ DataHelpers.getAsDate(item, 'invoiceDate', 'date:br') }}</CrudTBodyTD>
                            <CrudTBodyTD
                                :contentClasses="{
                                    'inline-flex rounded-full bg-opacity-10 py-1 px-3 text-sm font-medium': true,
                                    'bg-warning text-warning': item.status === 'Pending',
                                    'bg-danger text-danger': item.status === 'Unpaid',
                                    'bg-success text-success': item.status === 'Paid'
                                }"
                            >{{ item.status }}</CrudTBodyTD>
                            <td class="py-1 px-3">
                                <div class="flex items-center space-x-3.5">
                                    <CustomizableButton
                                        rounded="lg"
                                        outline="!false"
                                        :extraAttributes="{
                                            a: 123,
                                            type: 'menu',
                                        }"
                                        leftContent="lc"
                                        rightContent="rc"
                                    >
                                        <template v-slot:leftContent>lc tpl</template>
                                        Algo
                                        <template v-slot:rightContent>
                                            <!-- <component :is="icon"></component> -->
                                            <!-- <SvgIcon2 :icon="icon"/> -->
                                            <SvgIcon :icon="icon"/>
                                        </template>
                                    </CustomizableButton>

                                    <button class="hover:text-primary">
                                        <SvgIcon icon="OpenedEyeIcon"/>
                                    </button>

                                    <button class="hover:text-primary">
                                        <SvgIcon icon="DownloadIcon"/>
                                    </button>

                                    <button class="hover:text-primary">
                                        <SvgIcon icon="TrashIcon"/>
                                    </button>
                                </div>
                            </td>
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
