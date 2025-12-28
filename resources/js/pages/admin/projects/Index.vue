<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import {
    Table,
    TableBody,
    TableCaption,
    TableCell,
    TableFooter,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table'
import { Button } from '@/components/ui/button';
import { Plus, Eye, SquarePen, Trash2Icon } from 'lucide-vue-next';
import { Link } from '@inertiajs/vue3';
import { dashboard } from "@/routes";
import { type BreadcrumbItem } from '@/types';
import PageHeader from '@/components/PageHeader.vue';
import NoResults from '@/components/NoResults.vue';
import type {  PaginationLink } from '@/types/models';
import Pagination from '@/components/Pagination.vue';
import { create as projectCreate } from '@/routes/admin/projects';
import { show as projectShow } from '@/routes/admin/projects';
import { edit as projectEdit } from '@/routes/admin/projects';
import { destroy as projectDelete } from '@/routes/admin/projects';
import ModalLink from '@/components/ModalLink.vue';
import StatusBadge from '@/components/StatusBadge.vue';
import { deleteBySwal } from '@/composables/useSwal';

interface Project {
    id: number;
    title: string;
    client_id: number;
    client_name: string | null;
    type: string;
    description: string;
    start_date: string;
    deadline: string;
    progress: number;
    status: 'Active' | 'Completed' | 'Pending';
    created_at: string;
}
interface Flash {
    message?: string;
    type?: string;
}

interface PaginatedProjects {
    data: Project[];
    current_page: number;
    last_page: number;
    per_page: number;
    total?: number;
    from?: number;
    to?: number;
    links: PaginationLink[];
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

            <div v-if="props.projects && props.projects.data.length > 0"
                class="overflow-x-auto bg-white dark:bg-gray-900 rounded shadow">
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead>ID</TableHead>
                            <TableHead>Title</TableHead>
                            <TableHead>Client</TableHead>
                            <TableHead>Start Dtae</TableHead>
                            <TableHead>Deadline</TableHead>
                            <TableHead>Status</TableHead>
                            <TableHead class="text-right">Actions</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="item in props.projects.data" :key="item.id">
                            <TableCell>{{ item.id }}</TableCell>
                            <TableCell>{{ item.title }}</TableCell>
                            <TableCell>{{ item.client_name }}</TableCell>
                            <TableCell>{{ item.start_date }}</TableCell>
                            <TableCell>{{ item.deadline }}</TableCell>
                            <TableCell><StatusBadge :status="item.status" /></TableCell>
                            <TableCell class="text-right flex gap-2 justify-end">                    
                                <Link :href="projectShow(item.id).url">
                                    <Button variant="show" size="sm">
                                        <Eye class="w-4 h-4" />
                                    </Button>
                                </Link>
                                <ModalLink :href="projectEdit(item.id).url" variant="edit" :size="'sm'">
                                    <SquarePen class="w-4 h-4" />
                                </ModalLink>
                                <Button @click="deleteBySwal(projectDelete({ project: item.id }).url, 'project')"
                                    variant="delete" size="sm" title="Delete project">
                                    <Trash2Icon class="w-4 h-4" />
                                </Button>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
                <Pagination :from="Number(props.projects.from)" :to="Number(props.projects.to)"
                    :total="Number(props.projects.total)" :links="props.projects.links" class="mt-4" />
            </div>
            <NoResults v-else />
        </div>
    </AppLayout>
</template>