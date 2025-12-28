<script setup lang="ts">
import PageHeader from '@/components/PageHeader.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from "@/routes";
import { index as clientsIndex } from '@/routes/admin/clients';
import { type BreadcrumbItem } from '@/types';
import TabMenu from './TabMenu.vue';

interface Project {
    id: number;
    title?: string;
    start_date?: string | null;
    deadline?: string | null;
    status?: string | null;
}

interface Client {
    id: number;
    company_name?: string;
}

const props = defineProps<{
    client: Client;
    projects: Project[];
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

        <div class="mt-6 bg-white dark:bg-gray-900 rounded shadow">
            <div class="p-6">
                <h2 class="text-2xl font-semibold mb-4">Projects</h2>
                <div v-if="props.projects && props.projects.length > 0" class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b">
                                <th class="py-3 px-4 text-left">ID</th>
                                <th class="py-3 px-4 text-left">Title</th>
                                <th class="py-3 px-4 text-left">Start Date</th>
                                <th class="py-3 px-4 text-left">Deadline</th>
                                <th class="py-3 px-4 text-left">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="proj in props.projects" :key="proj.id" class="border-b hover:bg-gray-50 dark:hover:bg-gray-800">
                                <td class="py-3 px-4">{{ proj.id }}</td>
                                <td class="py-3 px-4">{{ proj.title ?? '—' }}</td>
                                <td class="py-3 px-4">{{ proj.start_date ?? '—' }}</td>
                                <td class="py-3 px-4">{{ proj.deadline ?? '—' }}</td>
                                <td class="py-3 px-4">{{ proj.status ?? '—' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div v-else class="text-gray-500 py-8 text-center">No projects found.</div>
            </div>
        </div>
    </div>
</AppLayout>
</template>