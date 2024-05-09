<script setup lang="ts">
import { useSidebarStore } from '@/stores/sidebar'
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3';

const sidebarStore = useSidebarStore()

const props = defineProps(['items', 'page']);
const items = ref(props.items);

const handleItemClick = (index: number) => {
    console.log('setIsSidebarOpen');
    sidebarStore.setIsSidebarOpen(false);
    const pageName = sidebarStore.selected === props.items[index].label ? '' : props.items[index].label;
    sidebarStore.selected = pageName;
}
</script>

<template>
    <ul class="my-1 mb-5.5 flex flex-col gap-1 pl-6">
        <template v-for="(childItem, index) in items" :key="index">
        <li>
            <Link
                :href="childItem.href"
                data-item-type="sidebar-link"
                @click.prevent="handleItemClick(index)"
                class="group relative flex items-center gap-2.5 rounded-md py-2 px-4 font-medium text-bodydark2 duration-300 ease-in-out"
                :class="{
                    'bg-gray-800 dark:bg-gray-800 hover:bg-gray-600 dark:hover:bg-gray-600': true,
                    '!text-white': childItem.label === sidebarStore.selected,
                    'bg-gray-600 dark:bg-gray-600': childItem.active,
                    'active': childItem.active,
                }"
            >
                {{ childItem.label }}
            </Link>
        </li>
        </template>
    </ul>
</template>
