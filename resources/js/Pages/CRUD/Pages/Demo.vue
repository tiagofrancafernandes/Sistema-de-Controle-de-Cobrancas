<script setup lang="ts">
import { router } from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import * as DataHelpers from '@/Libs/Helpers/DataHelpers';
import { dataGet, objectOnly, mergeObjects } from '@/Libs/Helpers/DataHelpers';
import { validClassMerge } from '@/Libs/Helpers/CssHelpers';

import TableOne from '@/Components/Tables/TableOne.vue'
import TableTwo from '@/Components/Tables/TableTwo.vue'
import TableThree from '@/Components/Tables/TableThree.vue'
import CustomTable from '@/Components/Tables/CustomTable.vue'
import TailAdminLayout from '@/Layouts/TailAdminLayout.vue';

import DemoItems from '@/EasyCrud/Components/CRUD/Parts/Demo/Items.vue';

const emit = defineEmits(['update:checked']);

const pageProps = defineProps({
    pageTitle: {
        type: String,
    },
});

const pageTitle = computed(() => pageProps?.pageTitle ?? 'CRUD Demo');
const pageSubtitle = computed(() => 'Demo');

const breadcrumbItems = [
    {
        label: pageTitle.value,
        href: '/profile',
    },
    {
        label: pageSubtitle.value,
    }
];
</script>

<template>
    <TailAdminLayout
        :pageTitle="pageTitle"
        :breadcrumbItems="breadcrumbItems"
    >
        <div class="grid grid-cols-4">
            <div class="col-span-4">
                <DemoItems/>
            </div>
        </div>
    </TailAdminLayout>
</template>
