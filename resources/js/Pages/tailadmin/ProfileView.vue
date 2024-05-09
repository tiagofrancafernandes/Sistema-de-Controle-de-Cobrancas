<script setup lang="ts">
import { ref } from 'vue'
import BreadcrumbDefault from '@/Components/Breadcrumbs/BreadcrumbDefault.vue'
import ProfileCard from '@/Components/ProfileCard.vue'
import TailAdminLayout from '@/Layouts/TailAdminLayout.vue'

const pageTitle = ref('Profile')
</script>

<template>
  <TailAdminLayout>
    <div class="mx-auto max-w-242.5">
      <!-- Breadcrumb Start -->
      <BreadcrumbDefault :pageTitle="pageTitle" />
      <!-- Breadcrumb End -->
      <ProfileCard />
    </div>
  </TailAdminLayout>
</template>
