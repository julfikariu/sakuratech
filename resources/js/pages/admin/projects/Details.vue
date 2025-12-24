<script setup lang="ts">
import TabMenu from './TabMenu.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import PageHeader from '@/components/PageHeader.vue';
import { dashboard } from "@/routes";
import { index as projectIndex } from '@/routes/admin/projects';

import { type BreadcrumbItem } from '@/types';
import type { Project } from '@/types/models';

const props = defineProps<{
    project: Project;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Projects',
        href: projectIndex().url,
    },
    {
        title: props.project.title,
        href: '',
    },
];

</script>

<template>

<AppLayout>
    <div class="p-6">
        <PageHeader :title="`Project Details - ${props.project.title}`" description="" :breadcrumbs="breadcrumbs">
        </PageHeader>

        <TabMenu :project_id="props.project.id" />
        <div class="mt-6 bg-white dark:bg-gray-900 rounded shadow">
            <div class="p-6">
                <!-- Project details content goes here -->
                <h2 class="text-2xl font-semibold mb-4">Project Information</h2>
                <p><strong>Project Name:</strong> {{ props.project.title }}</p>
                <p><strong>Description:</strong> {{ props.project.description }}</p>
                <p><strong>Start Date:</strong> {{ props.project.start_date }}</p>
            </div>
        </div>
    </div>
</AppLayout>

</template>


