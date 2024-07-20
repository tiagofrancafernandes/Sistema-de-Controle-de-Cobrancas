<script setup lang="js">
import { onMounted, ref, useSlots, useAttrs ,computed } from 'vue'

const emit = defineEmits([
    'change',
    'input',
]);

const props = defineProps({
    name: {
        type: String,
        default: null,
    },
    id: {
        type: String,
        default: null,
    },
    label: {
        type: String,
        default: null,
    },
    tag: {
        type: String,
        default: 'input',
    },
    type: {
        type: String,
        default: 'text',
    },
    placeholder: {
        type: String,
        default: '',
    },
    modelValue: {
        // type: [String, Number, Boolean],
        required: true,
        default: null,
    },
    class: {
        type: [String, Object, Array],
        default: null,
    },
    containerClass: {
        type: [String, Object, Array],
        default: [],
    },
});


const slots = useSlots();
const attrs = useAttrs();

// console.log('modelValue', props.modelValue);
/* // START  resources/js/Components/TextInput.vue */
// const model = defineModel();

const input = ref(null);

onMounted(() => {
    if (input?.value?.hasAttribute('autofocus')) {
        input.value?.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
/* // END  resources/js/Components/TextInput.vue */

import CustomTextInput from '@/Components/CustomTextInput.vue';
const inputTag = computed(() => {
    let tag = props.tag || 'input';

    switch (tag) {
        // case 'textarea':
        //     // ...
        //     break;

        case 'input' | 'date' | 'datetime':
        default:
            return CustomTextInput;
            break;
    }
})

const inputType = computed(() => {
    let type = props.type || 'text';

    let matchType = useMatchCheck([
        [['datetime', 'datetime-local'], 'datetime-local'],
    ]);

    return matchType(
        type,
        ['text', 'date', 'password', 'hidden', /* ... */].includes(type) ? type : 'text',
    );
});

const alterLabel = computed(() => {
    return props.label || toTitle(props.name || '');
});

const inputProps = computed(() => {
    return {
        ...(attrs || {}),
        ...(props || {}),
        type : inputType.value,
        id : props.id || null,
        name : props.name,
        // modelValue : props.modelValue,
        placeholder : props.placeholder || alterLabel.value,
        class: [
            'focus:ring-0',
            // 'border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-900 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white',
            props.class || [],
        ],
    };
});

const modelValue = defineModel({
    type: [String, Number, Boolean],
    default: '',
})

const onChangeHandler = (event) => {
    emit('change', event);
}

const onInputHandler = (event) => {
    emit('input', event);
    onChangeHandler(event);
}

const containerAttributes = computed(() => {
    return {
        class: validClassMerge(props?.containerClass),
        'data-component-name': 'basic-input-container',
    };
})
</script>

<template>
    <div v-bind="containerAttributes">
        <template v-if="slots.label || alterLabel">
            <template
                v-if="!slots.label"
            >
                <label
                    v-bind:for="props.id || null"
                    class="block mb-1 text-sm font-medium text-gray-900 dark:text-white"
                    v-html="alterLabel ?? ''"
                ></label>
            </template>
            <template v-else>
                <slot  name="label"/>
            </template>
        </template>

        <component
            :is="inputTag"
            v-bind="inputProps"
            v-model="modelValue"
            v-on:input="onInputHandler"
        />
    </div>
</template>
