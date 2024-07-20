<script setup lang="js">
import { useSlots, useAttrs, computed } from 'vue'

const props = defineProps({
    paginationConfig: {
        type: [Object],
    },
    hide: {
        type: Boolean,
        default: false,
    },
})
// const slots = useSlots()
// const attrs = useAttrs()

const paginationConfigData = computed(() => {
    if (!props.paginationConfig) {
        return {};
    }

    return props.paginationConfig || {};
})

const toHide = computed(() => {
    if (props.hide) {
        return true;
    }

    let paginationCfg = paginationConfigData.value;


    if (!dataGet(paginationCfg, 'info.pageCount') || !dataGet(paginationCfg, 'links.length')) {
        return true;
    }

    return false;
})

const paginationLinks = computed(() => {
    if (toHide.value) {
        return [];
    }

    let paginationCfg = paginationConfigData.value;
    let links = dataGet(paginationCfg, 'links', []);

    return (Array.isArray(links) ? links : [])
        .filter(item => isObject(item))
        .map(item => {
            return {
                active: item['active'] ?? false,
                ...item,
            }
        });
})

</script>

<template>
<div
    v-if="!toHide"
    class="flex flex-col space-y-4 items-end justify-end"
>
    <nav>
        <ul class="flex items-center -space-x-px h-10 text-base">
            <!-- <li>
                <a href="#" class="flex items-center justify-center px-4 h-10 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                    <span class="sr-only">Previous</span>
                    <svg class="w-3 h-3 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"></path>
                    </svg>
                </a>
            </li>
            -->
            <template
                v-for="(paginationLink, paginationLinkIndex) in paginationLinks"
                :key="paginationLinkIndex"
            >
                <li>
                    <component
                        :is="paginationLink && paginationLink.disabled ? 'span' : 'Link'"
                        :href="`?${paginationLink.url}`"
                        :class="[
                            'flex items-center justify-center px-4 h-10 leading-tight border',
                            {
                                'hover:bg-gray-100 hover:text-gray-700 dark:hover:bg-gray-700 dark:hover:text-white': !paginationLink.disabled,
                                'text-gray-500 bg-white border-gray-300 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400': !paginationLink.active,
                                'z-10 text-blue-600  border-blue-300 bg-blue-50 dark:border-gray-700 dark:bg-gray-700 dark:text-white': paginationLink.active,
                            }
                        ]"
                        :aria-current="paginationLink.active ? 'page' : null"
                        v-html="paginationLink.label"
                        preserve-scroll
                    />
                </li>

            </template>
            <!--
            <li>
                <a href="#" class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">2</a>
            </li>
            <li>
                <a href="#" aria-current="page" class="z-10 flex items-center justify-center px-4 h-10 leading-tight text-blue-600 border border-blue-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">3</a>
            </li>
            -->
            <!--
            <li>
                <a href="#" class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                    <span class="sr-only">Next</span>
                    <svg class="w-3 h-3 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"></path>
                    </svg>
                </a>
            </li> -->
        </ul>
    </nav>
</div>
</template>
