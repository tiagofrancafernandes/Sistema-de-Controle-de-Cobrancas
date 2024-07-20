<script setup lang="js">
import { useSlots, useAttrs } from 'vue'

const props = defineProps({
    titleContent: {
        type: String,
        default: null,
    },
    bodyContent: {
        type: String,
        default: null,
    },
    footerContent: {
        type: String,
        default: null,
    },
})

const slots = useSlots()
const attrs = useAttrs()


</script>

<template>
<div
    class="block p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700"
>
    <template v-if="slots.title || attrs.title || props.titleContent">
        <template
            v-if="!slots.title"
        >
            <div v-html="props.titleContent ?? attrs.title ?? ''"></div>
        </template>
        <template v-else>
            <slot  name="title"/>
        </template>
    </template>

    <template v-if="slots.default || attrs.body || props.bodyContent">
        <template
            v-if="!slots.default"
        >
            <div v-html="props.bodyContent ?? attrs.body ?? ''"></div>
        </template>
        <template v-else>
            <slot/>
        </template>
    </template>

    <template v-if="slots.footer || attrs.footer || props.footerContent">
        <template
            v-if="!slots.footer"
        >
            <div v-html="props.footerContent ?? attrs.footer ?? ''"></div>
        </template>
        <template v-else>
            <slot  name="footer"/>
        </template>
    </template>
</div>
</template>
