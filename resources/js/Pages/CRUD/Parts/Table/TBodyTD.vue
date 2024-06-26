<script setup lang="js">
import { computed } from 'vue';
const props = defineProps([
    'label',
    'rowClasses',
    'contentClasses',
])

const rowClasses = computed(() => {
    if (props?.rowClasses) {
        return props?.rowClasses;
    }

    return 'py-1 px-3';
})

const contentClasses = computed(() => {
    if (props?.contentClasses) {
        return props?.contentClasses;
    }

    return 'text-black dark:text-white';
})
</script>

<template>
<td :class="rowClasses">
    <div
        :class="contentClasses"
    ><slot></slot> {{ props.label }}</div>
</td>
</template>
