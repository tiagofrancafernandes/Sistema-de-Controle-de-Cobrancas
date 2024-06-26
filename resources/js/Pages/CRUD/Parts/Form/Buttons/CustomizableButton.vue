<script setup lang="js">
import { computed, useSlots, useAttrs } from 'vue'
import { sizeIsValid, validCssSize, validClassMerge } from '@/Libs/Helpers/CssHelpers';
import { roundedProperty } from '@/Libs/Helpers/TWHelpers';
import { valueToType, evaluateOrValue } from '@/Libs/Helpers/FunctionHelpers';
import { useExtraAttributes } from '@/Libs/Helpers/VueComponentHelpers';
import { buttonPresetColors } from '@/Libs/Helpers/Tw/TwPresets';

const slots = useSlots();
const attrs = useAttrs();
const props = defineProps([
    'label',
    'type',
    'color',
    'btnClass',
    'rounded',
    'extraAttributes',
    'contentClasses',
    'leftContent',
    'rightContent',
])

const propsAndAttrs = computed(() => ({
    ...props,
    ...attrs,
}))

const roundedValue = computed(() => {
    let defaultSize = 'md';
    let rounded = props?.rounded ?? extraAttributes['rounded'] ?? defaultSize;

    return roundedProperty(rounded, defaultSize);
})

const extraAttributes = useExtraAttributes(propsAndAttrs);

const btnType = computed(() => {
    let type = props?.type || extraAttributes['type'] || null;
    return ['submit', 'reset', 'button', 'menu'].includes(type) ? type : 'button';
});

const outlined = computed(() => {
    let defaultValue = true;
    let outline = valueToType(
        evaluateOrValue(props?.outline ?? propsAndAttrs.value['outline'] ?? defaultValue),
        'boolean'
    );

    if (outline === null) {
        outline = defaultValue;
    }

    if (!outline || [false, 'false', 0, 'none'].includes(color)) {
        return false;
    }

    return !!outline;
})

let defaultColor = 'blue';
const color = computed(() => {
    let color = props?.color ?? extraAttributes['color'] ?? defaultColor;

    if (color === null) {
        color = defaultColor;
    }

    if (!color || [false, 'false', 0, 'none'].includes(color)) {
        return [];
    }

    return color in buttonPresetColors ? color : defaultColor;
})

const colorClasses = computed(() => {
    let presetColor = buttonPresetColors[color.value] ?? (presetColor[defaultColor] ?? {});

    let mode = outlined.value ? 'outlined' : 'noOutlined';
    presetColor = validClassMerge(
        presetColor['shared'] ?? [],
        presetColor[mode] ?? [],
    );

    return presetColor;
})

const btnClass = computed(() => {
    let baseClasses = [
        'gap-3',
        roundedValue.value,
    ];

    return validClassMerge(
        outlined.value ? 'outlined-true' : 'outlined-false',
        baseClasses,
        colorClasses.value,
        props?.classes,
    );
})
</script>

<template>
<button
    :type="btnType"
    :class="btnClass"
    v-bind="extraAttributes"
>
    <template
        v-if="slots.leftContent"
    >
        <slot name="leftContent"></slot>
    </template>
    <template v-else>
        {{ propsAndAttrs?.leftContent }}
    </template>

    <template
        v-if="!slots.default"
    >
        {{ propsAndAttrs?.label }}
    </template>
    <template v-else>
        <slot/>
    </template>

    <template
        v-if="slots.rightContent"
    >
        <slot name="rightContent"></slot>
    </template>
    <template v-else>
        {{ propsAndAttrs?.rightContent }}
    </template>
</button>
</template>
