<script setup lang="ts">
import PageHeader from '@/components/PageHeader.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from "@/routes";
import { index as clientsIndex } from '@/routes/admin/clients';
import { type BreadcrumbItem } from '@/types';
import TabMenu from './TabMenu.vue';
import ProjectTable from '@/components/projects/ProjectTable.vue';
import type { PaginatedProjects } from '@/types/project';

interface Client {
    id: number;
    company_name?: string;
}

const props = defineProps<{
    client: Client;
    projects: PaginatedProjects | null;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Clients',
        href: clientsIndex().url,
    },
    {
        title: props.client.company_name ?? `Client #${props.client.id}`,
        href: '',
    },
];
</script>

<template>
<AppLayout>
    <div class="p-6">
        <PageHeader :title="`Client - ${props.client.company_name ?? ('#' + props.client.id)}`" description="" :breadcrumbs="breadcrumbs" />

        <TabMenu :client_id="props.client.id" />

        <ProjectTable :projects="props.projects" :showClientColumn="false" />
                  
    </div>
</AppLayout>
</template>