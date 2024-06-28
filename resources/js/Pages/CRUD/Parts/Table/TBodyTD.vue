<script setup lang="js">
import { computed, useSlots, useAttrs } from 'vue';
import { dataGet, objectOnly, mergeObjects } from '@/Libs/Helpers/DataHelpers';

const slots = useSlots();
const attrs = useAttrs();

const props = defineProps([
    'label',
    'html',
    'rowClasses',
    'contentClasses',
])

const propsAndAttrs = computed(() => {
    let merged = mergeObjects(
        props,
        attrs,
    );

    // console.clear();
    // console.log('merged', merged);

    return merged;
});

const rowClasses = computed(() => {
    if (propsAndAttrs.value?.rowClasses) {
        return propsAndAttrs.value?.rowClasses;
    }

    return 'py-1 px-3';
})

const contentClasses = computed(() => {
    if (propsAndAttrs.value?.contentClasses) {
        return propsAndAttrs.value?.contentClasses;
    }

    return validClassMerge(propsAndAttrs.value?.class, 'text-black dark:text-white');
})

const htmlContent = computed(() => {
    let htmlContent = propsAndAttrs.value?.html || attrs?.html || props?.html;

    if (typeof htmlContent === 'string') {
        return htmlContent;
    }

    return propsAndAttrs.content || propsAndAttrs.label;
})
</script>

<template>
<td :class="rowClasses">
    <div
        :class="contentClasses"
    >
        <template v-if="htmlContent">
            {{ htmlContent }}
        </template>
        <template v-else>
            <template v-if="propsAndAttrs.content || propsAndAttrs.label">
                {{ propsAndAttrs.content || propsAndAttrs.label }}
            </template>
            <template v-else>
                <slot/>
            </template>
        </template>
    </div>
</td>
</template>
