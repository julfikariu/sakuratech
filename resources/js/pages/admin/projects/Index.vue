<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Plus } from 'lucide-vue-next';
import { dashboard } from "@/routes";
import { type BreadcrumbItem } from '@/types';
import PageHeader from '@/components/PageHeader.vue';
import { create as projectCreate } from '@/routes/admin/projects';
import ModalLink from '@/components/ModalLink.vue';
import ProjectTable from '@/components/projects/ProjectTable.vue';
import type { PaginatedProjects } from '@/types/project';

interface Flash {
    message?: string;
    type?: string;
}

const props = defineProps<{
    projects: PaginatedProjects | null;
    flash?: Flash;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Projects',
        href: '',
    },
];

</script>

<template>
    <AppLayout>

        <div class="p-6">
            <PageHeader title="All Project" description="" :breadcrumbs="breadcrumbs">
               
            </PageHeader>

            <div class="flex justify-between items-center w-full">
                <ModalLink  :href="projectCreate().url" :variant="'save'" title="Create New Project">                   
                    <Plus /> Add New                
                </ModalLink>
                               
                <div class="w-1/3">
                    <!-- <Search /> -->
                </div>
            </div>

            <ProjectTable :projects="props.projects" />
        </div>
    </AppLayout>
</template>