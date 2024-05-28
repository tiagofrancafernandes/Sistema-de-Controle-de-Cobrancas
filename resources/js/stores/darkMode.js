import { ref } from 'vue'
import { defineStore } from 'pinia'
import { useStorage } from '@vueuse/core'

const defaultDarkMode = import.meta.env.VITE_DEFAULT_DARK_MODE || false;

export const useDarkModeStore = defineStore('darkMode', () => {
    const darkMode = useStorage('darkMode', ref(defaultDarkMode ?? false))

    document.documentElement.classList.toggle('dark', darkMode.value)

    function toggleDarkMode() {
        darkMode.value = !darkMode.value
        document.documentElement.classList.toggle('dark', darkMode.value)
    }

    return { darkMode, toggleDarkMode }
})
