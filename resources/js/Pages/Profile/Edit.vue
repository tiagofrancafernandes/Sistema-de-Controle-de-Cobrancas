<script setup>
// import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TailAdminLayout from '@/Layouts/TailAdminLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head } from '@inertiajs/vue3';
import { computed } from 'vue';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const pageTitle = computed(() => 'Profile');
const pageSubtitle = computed(() => 'Edit');

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
    <Head :title="pageTitle" />

    <TailAdminLayout
        :breadcrumbItems="breadcrumbItems"
    >
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight" v-text="pageTitle"></h2>
            <h4 class=" leading-tight" v-text="pageSubtitle"></h4>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <UpdateProfileInformationForm
                        :must-verify-email="mustVerifyEmail"
                        :status="status"
                        class="max-w-xl"
                    />
                </div>

                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <UpdatePasswordForm class="max-w-xl" />
                </div>

                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <DeleteUserForm class="max-w-xl" />
                </div>
            </div>
        </div>
    </TailAdminLayout>
</template>
