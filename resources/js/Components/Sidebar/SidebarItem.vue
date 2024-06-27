<script setup lang="ts">
import { useSidebarStore } from '@/stores/sidebar';
// import { useRoute } from 'vue-router'
import SidebarDropdown from '@/Components/Sidebar/SidebarDropdown.vue';
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const sidebarStore = useSidebarStore()

const props = defineProps(['item', 'index'])
// const currentPage = useRoute().name
const currentPage = computed(() => route().current)

interface SidebarItem {
    label: string
}

const handleItemClick = (event) => {
    const pageName = sidebarStore.page === props.item.label ? '' : props.item.label;
    sidebarStore.page = pageName;

    if (props.item.children) {
        return props.item.children.some((child: SidebarItem) => sidebarStore.selected === child.label)
    }

    console.log('handleItemClick event', event);

    return event;
}
</script>

<template>
    <li>
        <template
            v-if="item.children"
        >
            <button
                type="button"
                @click.prevent="handleItemClick"
                class="inline-flex items-center w-full text-white focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"
                :class="{
                    'duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4': true,
                    'bg-graydark dark:bg-meta-4': sidebarStore.page === item.label,
                    'active': item.active,
                }"
            >
                <span v-if="item.icon" class="w-4 h-4 me-2" v-html="item.icon"></span>
                {{ item.label }}

                <svg
                    class="flex items-center justify-between right-4 -translate-y-4/2 fill-current w-4 h-4 me-2"
                    :class="{ 'rotate-180': sidebarStore.page === item.label }"
                    viewBox="0 0 20 20"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        fill-rule="evenodd"
                        clip-rule="evenodd"
                        d="M4.41107 6.9107C4.73651 6.58527 5.26414 6.58527 5.58958 6.9107L10.0003 11.3214L14.4111 6.91071C14.7365 6.58527 15.2641 6.58527 15.5896 6.91071C15.915 7.23614 15.915 7.76378 15.5896 8.08922L10.5896 13.0892C10.2641 13.4147 9.73651 13.4147 9.41107 13.0892L4.41107 8.08922C4.08563 7.76378 4.08563 7.23614 4.41107 6.9107Z"
                        fill=""
                    />
                </svg>
            </button>

            <!-- <button
                type="button"
                class="group relative text-center inline-flex items-center gap-2.5 rounded-lg py-2 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4"
                @click.prevent="handleItemClick"
                :class="{
                    'bg-graydark dark:bg-meta-4': sidebarStore.page === item.label
                }"
            >
                <span v-html="item.icon"></span>

                {{ item.label }}

                <svg
                    class="absolute right-4 top-1/2 -translate-y-1/2 fill-current"
                    :class="{ 'rotate-180': sidebarStore.page === item.label }"
                    width="20"
                    height="20"
                    viewBox="0 0 20 20"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        fill-rule="evenodd"
                        clip-rule="evenodd"
                        d="M4.41107 6.9107C4.73651 6.58527 5.26414 6.58527 5.58958 6.9107L10.0003 11.3214L14.4111 6.91071C14.7365 6.58527 15.2641 6.58527 15.5896 6.91071C15.915 7.23614 15.915 7.76378 15.5896 8.08922L10.5896 13.0892C10.2641 13.4147 9.73651 13.4147 9.41107 13.0892L4.41107 8.08922C4.08563 7.76378 4.08563 7.23614 4.41107 6.9107Z"
                        fill=""
                    />
                </svg>
            </button> -->
        </template>
        <template
            v-else
        >
        <!-- @click.prevent="handleItemClick" -->
        <!-- as="a" -->
            <Link
                :href="item.route ? route(item.route) : item.href"
                v-bind:data-component-item="'SidebarItem'"
                class="group relative flex items-center gap-2.5 rounded-lg py-2 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4"

                :class="{
                    'bg-graydark dark:bg-meta-4': sidebarStore.page === item.label,
                    'bg-graydark dark:bg-meta-4': item.active,
                    'active': item.active,
                }"
            >
                <span v-html="item.icon"></span>
                {{ item.label }}
            </Link>
        </template>


        <!-- Dropdown Menu Start -->
        <div class="translate transform overflow-hidden" v-show="sidebarStore.page === item.label">
            <SidebarDropdown
                v-if="item.children"
                :items="item.children"
                :currentPage="currentPage"
                :page="item.label"
            />
            <!-- Dropdown Menu End -->
        </div>
    </li>
</template>
