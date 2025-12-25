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
import type { PaginationLink } from '@/types/models';
import Pagination from '@/components/Pagination.vue';
import { create as invoiceCreate } from '@/routes/admin/invoices';
import { show as projectShow } from '@/routes/admin/invoices';
import { edit as invoiceEdit } from '@/routes/admin/invoices';
import { destroy as invoiceDelete } from '@/routes/admin/invoices';
import ModalLink from '@/components/ModalLink.vue';
import { deleteBySwal } from '@/composables/useSwal';

interface Flash {
    message?: string;
    type?: string;
}

interface Invoice {
    id: number;
    inv_unique_id: string;
    client_id: number;
    project_id: number;
    amount: number;
    issue_date: string;
    due_date: string;
}

interface PaginatedInvoices {
    data: Invoice[];
    current_page: number;
    last_page: number;
    per_page: number;
    total?: number;
    from?: number;
    to?: number;
    links: PaginationLink[];
}

const props = defineProps<{
    invoices: PaginatedInvoices | null;
    flash?: Flash;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Invoices',
        href: '',
    },
];

</script>

<template>
    <AppLayout>

        <div class="p-6">
            <PageHeader title="All Invoice" description="" :breadcrumbs="breadcrumbs">
               
            </PageHeader>

            <div class="flex justify-between items-center w-full">
                <ModalLink  :href="invoiceCreate().url" :variant="'save'" title="Create New Invoice">                   
                    <Plus /> Add New                
                </ModalLink>
                               
                <div class="w-1/3">
                    <!-- <Search /> -->
                </div>
            </div>

            <div v-if="props.invoices && props.invoices.data.length > 0"
                class="overflow-x-auto bg-white dark:bg-gray-900 rounded shadow">
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead>Invoice ID</TableHead>
                            <TableHead>Client</TableHead>
                            <TableHead>Project</TableHead>
                            <TableHead>Issue Date</TableHead>
                            <TableHead>Due Date</TableHead>
                            <TableHead class="text-right">Actions</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="item in props.invoices.data" :key="item.id">
                            <TableCell>{{ item.inv_unique_id }}</TableCell>
                            <TableCell>{{ item.client_id }}</TableCell>
                            <TableCell>{{ item.project_id }}</TableCell>
                            <TableCell>{{ item.issue_date }}</TableCell>
                            <TableCell>{{ item.due_date }}</TableCell>
                            <TableCell class="text-right flex gap-2 justify-end">                    
                                <Link :href="projectShow(item.id).url">
                                    <Button variant="show" size="sm">
                                        <Eye class="w-4 h-4" />
                                    </Button>
                                </Link>

                                 <Link :href="invoiceEdit(item.id).url">
                                    <Button variant="edit" size="sm">
                                        <SquarePen class="w-4 h-4" />
                                    </Button>
                                </Link>                       
                                <Button @click="deleteBySwal(invoiceDelete({ invoice: item.id }).url, 'invoice')"
                                    variant="delete" size="sm" title="Delete invoice">
                                    <Trash2Icon class="w-4 h-4" />
                                </Button>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
                <Pagination :from="Number(props.invoices.from)" :to="Number(props.invoices.to)"
                    :total="Number(props.invoices.total)" :links="props.invoices.links" class="mt-4" />
            </div>
            <NoResults v-else />
        </div>
    </AppLayout>
</template>