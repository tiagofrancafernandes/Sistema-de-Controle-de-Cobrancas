<script setup lang="js">
import { useSlots, useAttrs } from 'vue'
import { buttonPresetColors } from '@/Libs/Helpers/Tw/TwPresets';

const props = defineProps(['label'])
const slots = useSlots()
const attrs = useAttrs()

</script>

<template>
<div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="grid grid-cols-4 gap-3">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">buttonPresetColors</h2>

        <template v-for="(item, index) in Object.entries(buttonPresetColors)">
            <div :class="['col-span-4', 'py-2', 'space-y-2', 'border-b', 'pb-4', {'border-t mt-4': index === 0}]">
                <div>
                    <CrudCustomizableButton
                        :color="item[0]"
                        :outline="false"
                    >{{ item[0] }}</CrudCustomizableButton>

                    <code>{{ {
                        color: item[0],
                        outline: false,
                    } }}</code>
                </div>

                <div>
                    <CrudCustomizableButton
                        :color="item[0]"
                        :outline="true"
                    >{{ item[0] }}</CrudCustomizableButton>

                    <code>{{ {
                        color: item[0],
                        outline: true,
                    } }}</code>
                </div>
            </div>
        </template>
    </div>
</div>
</template>
