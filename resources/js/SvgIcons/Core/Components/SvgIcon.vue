<script setup>
import { useAttrs, computed } from 'vue';
import { iconComponentsPrefix } from '@SvgIcons/Core/Js/SvgIconPlugin';

const attrs = useAttrs();

const icon = computed(() => {
    let iconName = attrs?.icon || attrs?.iconName || null;
    iconName = typeof iconName === 'string' && iconName.trim() ? iconName.trim() : null;

    return iconName ? `${iconComponentsPrefix()}${iconName}` : null;
})
</script>

<template>
    <template v-if="icon">
        <component
            :is="icon"
            v-bind="attrs"
        ></component>
    </template>
</template>
