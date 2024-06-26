<script setup>
import { useAttrs, computed } from 'vue';
import { validPropertySize } from '@/Libs/Helpers/TWHelpers';
import { validClassMerge } from '@/Libs/Helpers/CssHelpers';

const attrs = useAttrs();

const defaultSize = 5;

const size = computed(() => {
    return attrs?.size ?? defaultSize;
})

const classes = computed(() => {
    let _classes = [
        'fill-current',
        validPropertySize('w', size.value),
        validPropertySize('h', size.value),
    ];

    return validClassMerge(
        _classes,
        attrs?.class,
    );
})
</script>

<template>
<svg
    :class="classes"
    v-bind="attrs"
    stub-viewBox=""
    stub-fill=""
    stub-xmlns=""
    stub-attrs
>
    <!-- #SVG_CONTENT# -->
</svg>
</template>
