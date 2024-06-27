<script setup lang="js">
import { computed, useSlots, useAttrs } from 'vue';
import { dataGet, objectOnly, mergeObjects } from '@/Libs/Helpers/DataHelpers';

const slots = useSlots();
const attrs = useAttrs();

const props = defineProps([
    'label',
    'lineOne',
    'lineTwo',
    'rowClasses',
    'lineOneClasses',
    'lineTwoClasses',
])

const propsAndAttrs = computed(() => {
    return mergeObjects(
        props,
        attrs,
    );
});

const rowClasses = computed(() => {
    if (propsAndAttrs.value?.rowClasses) {
        return propsAndAttrs.value?.rowClasses;
    }

    return 'py-1 px-3 pl-9 xl:pl-11';
})

const lineOneClasses = computed(() => {
    if (propsAndAttrs.value?.lineOneClasses) {
        return propsAndAttrs.value?.lineOneClasses;
    }

    return 'font-medium text-black dark:text-white';
})

const lineTwoClasses = computed(() => {
    if (propsAndAttrs.value?.lineTwoClasses) {
        return propsAndAttrs.value?.lineTwoClasses;
    }

    return 'text-sm';
})
</script>

<template>
<td
    :class="rowClasses"
    data-component-name="CrudTBodyTD2Lines"
>
    <h5 :class="lineOneClasses">
        <template v-if="!slots?.lineOne">
            <slot name="lineOne"></slot>
        </template>
        {{ propsAndAttrs.lineOne }}
    </h5>
    <p :class="lineTwoClasses">
        <template v-if="!slots?.lineTwo">
            <slot name="lineTwo"></slot>
        </template>
        {{ propsAndAttrs.lineTwo }}
    </p>
</td>
</template>
