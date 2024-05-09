import { useStorage } from '@vueuse/core'
import { defineStore } from 'pinia'
import { ref } from 'vue'

import * as TypeHelpers from '@/Libs/Helpers/TypeHelpers'

export const useSidebarStore = defineStore('sidebar', () => {
    const isSidebarOpen = ref(false)
    const selected = useStorage('selected', ref('eCommerce'))
    const page = useStorage('page', ref('Dashboard'))

    function toggleSidebar() {
        isSidebarOpen.value = !isSidebarOpen.value
    }

    function setIsSidebarOpen(value) {
        isSidebarOpen.value = TypeHelpers.toBool(value);
    }

    return {
        isSidebarOpen,
        toggleSidebar,
        setIsSidebarOpen,
        selected,
        page,
    }
})
