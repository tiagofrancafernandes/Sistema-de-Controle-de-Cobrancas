<script setup lang="js">
import { useSlots, useAttrs, ref } from 'vue'

const props = defineProps({
    expanded: {
        type: Boolean,
    },
});
const slots = useSlots();
const attrs = useAttrs();
let isCollapsed = ref(!!props.expanded);
</script>

<template>
    <div class="rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-white/5 dark:ring-white/10">
        <div
            class="fi-fo-builder-item-header flex items-center gap-x-3 overflow-hidden px-4 py-3 cursor-pointer select-none"
            v-on:click="isCollapsed = !isCollapsed"
        >
            <h4 class="text-sm font-medium text-gray-950 dark:text-white"><slot name="title"></slot></h4>
            <ul class="ms-auto flex items-center gap-x-3">
                <li
                    class="relative transition"
                    v-bind:class="{ '-rotate-180': !isCollapsed }"
                >
                    <div class="transition">
                        <button
                            style="--c-300:var(--gray-300);--c-400:var(--gray-400);--c-500:var(--gray-500);--c-600:var(--gray-600);" class="fi-icon-btn relative flex items-center justify-center rounded-lg outline-none transition duration-75 focus-visible:ring-2 disabled:pointer-events-none disabled:opacity-70 -m-1.5 h-8 w-8 text-gray-400 hover:text-gray-500 focus-visible:ring-primary-600 dark:text-gray-500 dark:hover:text-gray-400 dark:focus-visible:ring-primary-500 fi-color-gray fi-ac-action fi-ac-icon-btn-action"

                            title="Collapse"
                            type="button"
                        >
                            <span class="sr-only"> Collapse </span>
                            <svg class="fi-icon-btn-icon h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                                <path fill-rule="evenodd" d="M9.47 6.47a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 1 1-1.06 1.06L10 8.06l-3.72 3.72a.75.75 0 0 1-1.06-1.06l4.25-4.25Z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                </li>
            </ul>
        </div>

        <div v-show="isCollapsed" class="fi-fo-builder-item-content border-t border-gray-100 p-4 dark:border-white/10">
            <slot name="content"></slot>
        </div>
    </div>
</template>
