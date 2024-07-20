<script setup>
import { onMounted, ref, computed } from 'vue';

const props = defineProps({
    class: {
        type: [String, Object, Array],
        default: null,
    },
});

const model = defineModel({
    type: String,
    required: true,
});

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });

const inputClasses = computed(() => {
    return validClassMerge(
        props.class || {},
        [
            'focus:ring-0 block w-full p-2.5',
            'w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300',
            'focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600',
            'rounded-md shadow-sm'
        ]
    );
});
</script>

<template>
    <input
        :class="inputClasses"
        v-model="model"
        ref="input"
    />
</template>
