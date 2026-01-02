<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
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
import { Plus, Eye, SquarePen, Trash2Icon, Download } from 'lucide-vue-next';
import { deleteBySwal } from '@/composables/useSwal';
import NoResults from '@/components/NoResults.vue';
import Pagination from '@/components/Pagination.vue';
import { show as invoiceShow } from '@/routes/admin/invoices';
import { edit as invoiceEdit } from '@/routes/admin/invoices';
import { destroy as invoiceDelete } from '@/routes/admin/invoices';
import { download as invoiceDownload } from '@/routes/admin/invoices';
import { Button } from '@/components/ui/button';
import StatusBadge from '@/components/StatusBadge.vue';
import type { PaginatedInvoices } from '@/types/invoice';

const props = withDefaults(
    defineProps<{
        invoices: PaginatedInvoices | null;
        showClientColumn?: boolean;
    }>(),     {
    showClientColumn: true,
});

function downloadPdf(id: number) {
    const url = invoiceDownload({ invoice: id }).url;
    window.open(url, '_blank');
}

</script>

<template>
    <div v-if="props.invoices && props.invoices.data.length > 0"
        class="overflow-x-auto  mt-3 bg-white dark:bg-gray-900 rounded shadow">
        <Table>
            <TableHeader>
                <TableRow>
                    <TableHead>Invoice ID</TableHead>
                    <TableHead v-if="props.showClientColumn">Client</TableHead>
                    <TableHead>Project</TableHead>
                    <TableHead>Issue Date</TableHead>
                    <TableHead>Due Date</TableHead>
                    <TableHead>Status</TableHead>
                    <TableHead class="text-right">Actions</TableHead>
                </TableRow>
            </TableHeader>
            <TableBody>
                <TableRow v-for="item in props.invoices.data" :key="item.id">
                    <TableCell>{{ item.inv_unique_id }}</TableCell>
                    <TableCell v-if="props.showClientColumn">{{ item.client }}</TableCell>
                    <TableCell>{{ item.project }}</TableCell>
                    <TableCell>{{ item.issue_date }}</TableCell>
                    <TableCell>{{ item.due_date }}</TableCell>
                    <TableCell>
                        <StatusBadge :status="item.status" />
                    </TableCell>
                    <TableCell class="text-right flex gap-2 justify-end">

                        <Link :href="invoiceShow(item.id).url">
                            <Button variant="show" size="sm">
                                <Eye class="w-4 h-4" />
                            </Button>
                        </Link>
                        <Button @click="downloadPdf(item.id)" variant="download" size="sm" title="Download Invoice">
                            <Download class="w-4 h-4" />
                        </Button>

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
</template>
