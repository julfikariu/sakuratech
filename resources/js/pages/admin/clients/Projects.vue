<script setup lang="ts">
import PageHeader from '@/components/PageHeader.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from "@/routes";
import { index as clientsIndex } from '@/routes/admin/clients';
import { type BreadcrumbItem } from '@/types';
import TabMenu from './TabMenu.vue';
import NoResults from '@/components/NoResults.vue';
import { Table,
    TableBody,
    TableCell,
    TableHeader,
    TableHead,
    TableRow,
} from '@/components/ui/table'
import { Button } from '@/components/ui/button';
import { Plus, Eye, SquarePen, Trash2Icon } from 'lucide-vue-next';
import { Link } from '@inertiajs/vue3';
import { create as projectCreate } from '@/routes/admin/projects';
import { show as projectShow } from '@/routes/admin/projects';
import { edit as projectEdit } from '@/routes/admin/projects';
import { destroy as projectDelete } from '@/routes/admin/projects';
import { deleteBySwal } from '@/composables/useSwal';
import ModalLink from '@/components/ModalLink.vue';
import StatusBadge from '@/components/StatusBadge.vue';

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
                <div v-if="props.projects && props.projects.length > 0"
                class="overflow-x-auto bg-white dark:bg-gray-900 rounded shadow">
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead>ID</TableHead>
                            <TableHead>Title</TableHead>
                            <TableHead>Start Dtae</TableHead>
                            <TableHead>Deadline</TableHead>
                            <TableHead>Status</TableHead>
                            <TableHead class="text-right">Actions</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="item in props.projects" :key="item.id">
                            <TableCell>{{ item.id }}</TableCell>
                            <TableCell>{{ item.title }}</TableCell>
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
            </div>
            <NoResults v-else />
            </div>
        </div>
    </div>
</AppLayout>
</template>