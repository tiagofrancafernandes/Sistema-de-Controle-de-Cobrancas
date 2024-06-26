<script setup lang="ts">
import { ref } from "vue";

import ProductOne from "@/assets/images/product/product-01.png";
import ProductTwo from "@/assets/images/product/product-02.png";
import ProductThree from "@/assets/images/product/product-03.png";
import ProductFour from "@/assets/images/product/product-04.png";

const products = ref([
    {
        id: 1,
        name: "Apple Watch Series 7",
        category: "Electronics",
        price: 269,
        sold: 22,
        profit: 45,
        imageSrc: ProductOne,
    },
    {
        id: 2,
        name: "Macbook Pro M1",
        category: "Electronics",
        price: 546,
        sold: 34,
        profit: 125,
        imageSrc: ProductTwo,
    },
    {
        id: 3,
        name: "Dell Inspiron 15",
        category: "Electronics",
        price: 443,
        sold: 64,
        profit: 247,
        imageSrc: ProductThree,
    },
    {
        id: 4,
        name: "HP Probook 450",
        category: "Electronics",
        price: 499,
        sold: 72,
        profit: 103,
        imageSrc: ProductFour,
    },
]);

let openedActions = ref(null);
const showThis = (id) => openedActions.value && openedActions.value === id;
</script>

<template>
    <div class="w-full">
        <div class="min-w-[1170px]">
            <div
                class="grid grid-cols-12 rounded-t-[10px] bg-primary px-5 py-4 lg:px-7.5 2xl:px-11"
            >
                <div class="col-span-3"><h5 class="font-medium text-white">Name</h5></div>
                <div class="col-span-3">
                    <h5 class="font-medium text-white">Position</h5>
                </div>
                <div class="col-span-3">
                    <h5 class="font-medium text-white">Email</h5>
                </div>
                <div class="col-span-2"><h5 class="font-medium text-white">Role</h5></div>
                <div class="col-span-1">
                    <h5 class="text-right font-medium text-white">Edit</h5>
                </div>
            </div>

            <div class="bg-white dark:bg-boxdark overflow-x-auto">
                <template
                    v-for="(item, index) in 5"
                    :key="index"
                >
                    <div
                        class="grid grid-cols-12 border-t border-[#EEEEEE] px-5 py-4 dark:border-strokedark lg:px-7.5 2xl:px-11"
                    >
                        <div class="col-span-3">
                            <p class="text-[#637381] dark:text-bodydark">
                                Musharof Chowdhury
                            </p>
                        </div>
                        <div class="col-span-3">
                            <p class="text-[#637381] dark:text-bodydark">
                                Multidisciplinary Web Entrepreneur
                            </p>
                        </div>
                        <div class="col-span-3">
                            <p class="text-[#637381] dark:text-bodydark">
                                musharof@example.com
                            </p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-[#637381] dark:text-bodydark">Owner</p>
                        </div>
                        <div class="relative col-span-1">
                            <div>
                                <button type="button"
                                    v-on:click="openedActions = (openedActions == index +1) ? null : index +1"
                                    class="float-right inline-flex items-center gap-1.5 rounded-md px-3 py-1.5 text-sm text-black shadow-11 hover:text-primary dark:bg-meta-4 dark:text-white dark:shadow-none"
                                >
                                    Action
                                    <svg
                                        class="fill-current"
                                        width="16"
                                        height="16"
                                        viewBox="0 0 16 16"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                            d="M8.00039 11.4C7.85039 11.4 7.72539 11.35 7.60039 11.25L1.85039 5.60005C1.62539 5.37505 1.62539 5.02505 1.85039 4.80005C2.07539 4.57505 2.42539 4.57505 2.65039 4.80005L8.00039 10.025L13.3504 4.75005C13.5754 4.52505 13.9254 4.52505 14.1504 4.75005C14.3754 4.97505 14.3754 5.32505 14.1504 5.55005L8.40039 11.2C8.27539 11.325 8.15039 11.4 8.00039 11.4Z"
                                            fill=""
                                        ></path>
                                    </svg>
                                </button>
                                <div
                                    class="absolute right-0 z-1 w-full max-w-39.5 rounded-[5px] bg-white py-2.5 shadow-12 dark:bg-boxdark top-full mt-1"
                                    v-show="showThis(index + 1)"
                                >
                                    <button type="button"
                                        class="flex w-full px-4 py-2 text-sm hover:bg-whiter hover:text-primary dark:hover:bg-meta-4"
                                    >
                                        Edit</button
                                    ><button type="button"
                                        class="flex w-full px-4 py-2 text-sm hover:bg-whiter hover:text-primary dark:hover:bg-meta-4"
                                    >
                                        Delete</button
                                    ><button type="button"
                                        class="flex w-full px-4 py-2 text-sm hover:bg-whiter hover:text-primary dark:hover:bg-meta-4"
                                    >
                                        Details
                                    </button>
                                </div>
                            </div>
                            <div style="display: none">
                                <button type="button"
                                    class="float-right inline-flex items-center gap-1.5 rounded-md px-3 py-1.5 text-sm text-black shadow-11 hover:text-primary dark:bg-meta-4 dark:text-white dark:shadow-none"
                                >
                                    Action
                                    <svg
                                        class="fill-current"
                                        width="16"
                                        height="16"
                                        viewBox="0 0 16 16"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                            d="M8.00039 11.4C7.85039 11.4 7.72539 11.35 7.60039 11.25L1.85039 5.60005C1.62539 5.37505 1.62539 5.02505 1.85039 4.80005C2.07539 4.57505 2.42539 4.57505 2.65039 4.80005L8.00039 10.025L13.3504 4.75005C13.5754 4.52505 13.9254 4.52505 14.1504 4.75005C14.3754 4.97505 14.3754 5.32505 14.1504 5.55005L8.40039 11.2C8.27539 11.325 8.15039 11.4 8.00039 11.4Z"
                                            fill=""
                                        ></path>
                                    </svg>
                                </button>
                                <div
                                    class="absolute right-0 z-1 w-full max-w-39.5 rounded-[5px] bg-white py-2.5 shadow-12 dark:bg-boxdark bottom-full mb-1"
                                    style="display: none"
                                >
                                    <button type="button"
                                        class="flex w-full px-4 py-2 text-sm hover:bg-whiter hover:text-primary dark:hover:bg-meta-4"
                                    >
                                        Edit</button
                                    ><button type="button"
                                        class="flex w-full px-4 py-2 text-sm hover:bg-whiter hover:text-primary dark:hover:bg-meta-4"
                                    >
                                        Delete</button
                                    ><button type="button"
                                        class="flex w-full px-4 py-2 text-sm hover:bg-whiter hover:text-primary dark:hover:bg-meta-4"
                                    >
                                        Details
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <div
                class="grid grid-cols-12 bg-primary px-5 py-4 lg:px-7.5 2xl:px-11"
            >
                <div class="col-span-3"><h5 class="font-medium text-white">Name</h5></div>
                <div class="col-span-3">
                    <h5 class="font-medium text-white">Position</h5>
                </div>
                <div class="col-span-3">
                    <h5 class="font-medium text-white">Email</h5>
                </div>
                <div class="col-span-2"><h5 class="font-medium text-white">Role</h5></div>
                <div class="col-span-1">
                    <h5 class="text-right font-medium text-white">Edit</h5>
                </div>
            </div>

            <div
                class="grid grid-cols-12 rounded-b-[10px] bg-white dark:bg-boxdark px-2 py-1 lg:px-3 2xl:px-5"
            >
                <div class="col-span-12"></div>
            </div>

            <div
                class="grid grid-cols-12 rounded-b-[10px] bg-primary px-4 py-4 lg:px-3 2xl:px-5"
            >
                <div class="col-span-12">
                    <div class="flex flex-col space-y-2 items-end justify-end py-1 pr-1">
                        <nav>
                            <ul class="flex items-center -space-x-px h-8 text-base">
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
                </div>
            </div>
        </div>
    </div>
</template>
