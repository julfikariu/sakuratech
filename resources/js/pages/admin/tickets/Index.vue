<script setup lang="ts">
import ModalLink from '@/components/ModalLink.vue';
import NoResults from '@/components/NoResults.vue';
import PageHeader from '@/components/PageHeader.vue';
import Pagination from '@/components/Pagination.vue';
import StatusBadge from '@/components/StatusBadge.vue';
import { Button } from '@/components/ui/button';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow
} from '@/components/ui/table';
import { deleteBySwal } from '@/composables/useSwal';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from "@/routes";
import { create as ticketCreate, destroy as ticketDelete, edit as ticketEdit, show as ticketShow } from '@/routes/admin/tickets';
import { type BreadcrumbItem } from '@/types';
import type { PaginationLink } from '@/types/models';
import { Link } from '@inertiajs/vue3';
import { Eye, Plus, SquarePen, Trash2Icon } from 'lucide-vue-next';

interface Ticket {
    id: number;
    title: string;
    priority: 'Low' | 'Medium' | 'High';
    status: 'Open' | 'Pending' | 'Closed';
    assignee_name: string | null;
    created_at: string;
}
interface Flash {
    message?: string;
    type?: string;
}

interface PaginatedTickets {
    data: Ticket[];
    current_page: number;
    last_page: number;
    per_page: number;
    total?: number;
    from?: number;
    to?: number;
    links: PaginationLink[];
}

const props = defineProps<{
    tickets: PaginatedTickets | null;
    flash?: Flash;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Tickets',
        href: '',
    },
];

</script>

<template>
    <AppLayout>

        <div class="p-6">
            <PageHeader title="All Tickets" description="" :breadcrumbs="breadcrumbs">
            </PageHeader>

            <div class="flex justify-between items-center w-full">
                <ModalLink  :href="ticketCreate().url" :variant="'save'" title="Create New Ticket">                   
                    <Plus /> Add New                
                </ModalLink>
                                
                <div class="w-1/3">
                    <!-- <Search /> -->
                </div>
            </div>

            <div v-if="props.tickets && props.tickets.data.length > 0"
                class="overflow-x-auto bg-white dark:bg-gray-900 rounded shadow">
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead>ID</TableHead>
                            <TableHead>Title</TableHead>
                            <TableHead>Assignee</TableHead>
                            <TableHead>Priority</TableHead>
                            <TableHead>Status</TableHead>
                            <TableHead class="text-right">Actions</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="item in props.tickets.data" :key="item.id">
                            <TableCell>{{ item.id }}</TableCell>
                            <TableCell>{{ item.title }}</TableCell>
                            <TableCell>{{ item.assignee_name }}</TableCell>
                            <TableCell>{{ item.priority }}</TableCell>
                            <TableCell><StatusBadge :status="item.status" /></TableCell>
                            <TableCell class="text-right flex gap-2 justify-end">                    
                                <Link :href="ticketShow(item.id).url">
                                    <Button variant="show" size="sm">
                                        <Eye class="w-4 h-4" />
                                    </Button>
                                </Link>
                                <ModalLink :href="ticketEdit(item.id).url" variant="edit" :size="'sm'">
                                    <SquarePen class="w-4 h-4" />
                                </ModalLink>
                                <Button @click="deleteBySwal(ticketDelete({ ticket: item.id }).url, 'ticket')"
                                    variant="delete" size="sm" title="Delete ticket">
                                    <Trash2Icon class="w-4 h-4" />
                                </Button>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
                <Pagination :from="Number(props.tickets.from)" :to="Number(props.tickets.to)"
                    :total="Number(props.tickets.total)" :links="props.tickets.links" class="mt-4" />
            </div>
            <NoResults v-else />
        </div>
    </AppLayout>
</template>
