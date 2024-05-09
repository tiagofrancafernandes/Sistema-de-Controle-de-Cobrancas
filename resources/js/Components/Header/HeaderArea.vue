<script setup lang="ts">
import { useSidebarStore } from '@/stores/sidebar'
import DarkModeSwitcher from './DarkModeSwitcher.vue'
import DropdownMessage from './DropdownMessage.vue'
import DropdownNotification from './DropdownNotification.vue'
import DropdownUser from './DropdownUser.vue'
import { computed, ref } from "vue";
import { Link } from '@inertiajs/vue3';

const sidebarStore = useSidebarStore();
const showTopSearch = computed(() => false);

const topLinks = ref([
    {
        icon: `
                <svg
                  class="fill-current"
                  width="18"
                  height="18"
                  viewBox="0 0 18 18"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M6.10322 0.956299H2.53135C1.5751 0.956299 0.787598 1.7438 0.787598 2.70005V6.27192C0.787598 7.22817 1.5751 8.01567 2.53135 8.01567H6.10322C7.05947 8.01567 7.84697 7.22817 7.84697 6.27192V2.72817C7.8751 1.7438 7.0876 0.956299 6.10322 0.956299ZM6.60947 6.30005C6.60947 6.5813 6.38447 6.8063 6.10322 6.8063H2.53135C2.2501 6.8063 2.0251 6.5813 2.0251 6.30005V2.72817C2.0251 2.44692 2.2501 2.22192 2.53135 2.22192H6.10322C6.38447 2.22192 6.60947 2.44692 6.60947 2.72817V6.30005Z"
                    fill=""
                  />
                  <path
                    d="M15.4689 0.956299H11.8971C10.9408 0.956299 10.1533 1.7438 10.1533 2.70005V6.27192C10.1533 7.22817 10.9408 8.01567 11.8971 8.01567H15.4689C16.4252 8.01567 17.2127 7.22817 17.2127 6.27192V2.72817C17.2127 1.7438 16.4252 0.956299 15.4689 0.956299ZM15.9752 6.30005C15.9752 6.5813 15.7502 6.8063 15.4689 6.8063H11.8971C11.6158 6.8063 11.3908 6.5813 11.3908 6.30005V2.72817C11.3908 2.44692 11.6158 2.22192 11.8971 2.22192H15.4689C15.7502 2.22192 15.9752 2.44692 15.9752 2.72817V6.30005Z"
                    fill=""
                  />
                  <path
                    d="M6.10322 9.92822H2.53135C1.5751 9.92822 0.787598 10.7157 0.787598 11.672V15.2438C0.787598 16.2001 1.5751 16.9876 2.53135 16.9876H6.10322C7.05947 16.9876 7.84697 16.2001 7.84697 15.2438V11.7001C7.8751 10.7157 7.0876 9.92822 6.10322 9.92822ZM6.60947 15.272C6.60947 15.5532 6.38447 15.7782 6.10322 15.7782H2.53135C2.2501 15.7782 2.0251 15.5532 2.0251 15.272V11.7001C2.0251 11.4188 2.2501 11.1938 2.53135 11.1938H6.10322C6.38447 11.1938 6.60947 11.4188 6.60947 11.7001V15.272Z"
                    fill=""
                  />
                  <path
                    d="M15.4689 9.92822H11.8971C10.9408 9.92822 10.1533 10.7157 10.1533 11.672V15.2438C10.1533 16.2001 10.9408 16.9876 11.8971 16.9876H15.4689C16.4252 16.9876 17.2127 16.2001 17.2127 15.2438V11.7001C17.2127 10.7157 16.4252 9.92822 15.4689 9.92822ZM15.9752 15.272C15.9752 15.5532 15.7502 15.7782 15.4689 15.7782H11.8971C11.6158 15.7782 11.3908 15.5532 11.3908 15.272V11.7001C11.3908 11.4188 11.6158 11.1938 11.8971 11.1938H15.4689C15.7502 11.1938 15.9752 11.4188 15.9752 11.7001V15.272Z"
                    fill=""
                  />
                </svg>
        `,
        label: 'Dashboard',
        href: route('dashboard'),
    }
]);

const handleItemClick = (index: number) => {
    let topLinksItems = topLinks.value;
    const pageName = sidebarStore.selected === topLinksItems[index].label ? '' : topLinksItems[index].label;
    sidebarStore.selected = pageName;
    sidebarStore.setIsSidebarOpen(false);
}
</script>

<template>
    <header
        class="sticky top-0 z-999 flex w-full bg-white drop-shadow-1 dark:bg-boxdark dark:drop-shadow-none"
    >
        <div class="flex flex-grow items-center justify-between py-4 px-4 shadow-2 md:px-6 2xl:px-11">
            <div class="flex items-center gap-2 sm:gap-4 lg:hidden">
                <!-- Hamburger Toggle BTN -->
                <button
                    class="z-99999 block rounded-lg border border-stroke bg-white p-1.5 shadow-sm dark:border-strokedark dark:bg-boxdark lg:hidden"
                    @click="
                        () => {
                            console.log('Toggling Sidebar');
                            sidebarStore.toggleSidebar();
                        }
                    "
                >
                    <span class="relative block h-5.5 w-5.5 cursor-pointer">
                        <span class="du-block absolute right-0 h-full w-full">
                            <span
                                class="relative top-0 left-0 my-1 block h-0.5 w-0 rounded-lg bg-black delay-[0] duration-200 ease-in-out dark:bg-white"
                                :class="{ '!w-full delay-300': !sidebarStore.isSidebarOpen }"
                            ></span>
                            <span
                                class="relative top-0 left-0 my-1 block h-0.5 w-0 rounded-lg bg-black delay-150 duration-200 ease-in-out dark:bg-white"
                                :class="{ '!w-full delay-400': !sidebarStore.isSidebarOpen }"
                            ></span>
                            <span
                                class="relative top-0 left-0 my-1 block h-0.5 w-0 rounded-lg bg-black delay-200 duration-200 ease-in-out dark:bg-white"
                                :class="{ '!w-full delay-500': !sidebarStore.isSidebarOpen }"
                            ></span>
                        </span>

                        <span class="du-block absolute right-0 h-full w-full rotate-45">
                            <span
                                class="absolute left-2.5 top-0 block h-full w-0.5 rounded-lg bg-black delay-300 duration-200 ease-in-out dark:bg-white"
                                :class="{ '!h-0 delay-[0]': !sidebarStore.isSidebarOpen }"
                            ></span>
                            <span
                                class="delay-400 absolute left-0 top-2.5 block h-0.5 w-full rounded-lg bg-black duration-200 ease-in-out dark:bg-white"
                                :class="{ '!h-0 dealy-200': !sidebarStore.isSidebarOpen }"
                            ></span>
                        </span>
                    </span>
                </button>
                <!-- Hamburger Toggle BTN -->
                <Link class="block flex-shrink-0 lg:hidden" href="/">
                    <img src="@/assets/images/logo/logo-icon.svg" alt="Logo" />
                </Link>
            </div>

            <div
                v-if="!false"
                class="hidden sm:flex items-start gap-3 2xsm:gap-7"
            >
                <ul class="my-1 flex flex-col gap-1">
                    <template v-for="(linkItem, index) in topLinks" :key="index">
                        <li
                            v-if="linkItem.href"
                        >
                            <Link
                                :href="linkItem.href"
                                @click.prevent="handleItemClick(index)"
                                data-item-type="header-top-link"
                                class="group relative flex items-center gap-2.5 rounded-md py-2 px-4 font-medium text-bodydark2 duration-300 ease-in-out"
                                :class="{
                                    'bg-gray-800 dark:bg-gray-800 hover:bg-gray-600 dark:hover:bg-gray-600': true,
                                    '!text-white': linkItem.label === sidebarStore.selected,
                                }"
                            >
                                {{ linkItem.label }}
                            </Link>
                        </li>
                    </template>
                </ul>
            </div>

            <div
                class="hidden sm:block"
            >
                <form
                    v-if="showTopSearch"
                    action="https://formbold.com/s/unique_form_id"
                    method="POST"
                >
                    <div class="relative">
                        <button class="absolute top-1/2 left-0 -translate-y-1/2">
                            <svg
                                class="fill-body hover:fill-primary dark:fill-bodydark dark:hover:fill-primary"
                                width="20"
                                height="20"
                                viewBox="0 0 20 20"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                fill-rule="evenodd"
                                clip-rule="evenodd"
                                d="M9.16666 3.33332C5.945 3.33332 3.33332 5.945 3.33332 9.16666C3.33332 12.3883 5.945 15 9.16666 15C12.3883 15 15 12.3883 15 9.16666C15 5.945 12.3883 3.33332 9.16666 3.33332ZM1.66666 9.16666C1.66666 5.02452 5.02452 1.66666 9.16666 1.66666C13.3088 1.66666 16.6667 5.02452 16.6667 9.16666C16.6667 13.3088 13.3088 16.6667 9.16666 16.6667C5.02452 16.6667 1.66666 13.3088 1.66666 9.16666Z"
                                fill=""
                                />
                                <path
                                fill-rule="evenodd"
                                clip-rule="evenodd"
                                d="M13.2857 13.2857C13.6112 12.9603 14.1388 12.9603 14.4642 13.2857L18.0892 16.9107C18.4147 17.2362 18.4147 17.7638 18.0892 18.0892C17.7638 18.4147 17.2362 18.4147 16.9107 18.0892L13.2857 14.4642C12.9603 14.1388 12.9603 13.6112 13.2857 13.2857Z"
                                fill=""
                                />
                            </svg>
                        </button>

                        <input
                            type="text"
                            placeholder="Type to search..."
                            class="w-full xl:w-125 bg-transparent pr-4 pl-9 focus:outline-none"
                        />
                    </div>
                </form>
            </div>

            <div class="flex items-center gap-3 2xsm:gap-7">
                <ul class="flex items-center gap-2 2xsm:gap-4">
                    <li>
                        <!-- Dark Mode Toggler -->
                        <DarkModeSwitcher />
                        <!-- Dark Mode Toggler -->
                    </li>

                    <!-- Notification Menu Area -->
                    <DropdownNotification />
                    <!-- Notification Menu Area -->

                    <!-- Chat Notification Area -->
                    <DropdownMessage />
                    <!-- Chat Notification Area -->
                </ul>

                <!-- User Area -->
                <DropdownUser />
                <!-- User Area -->
            </div>
        </div>
    </header>
</template>
