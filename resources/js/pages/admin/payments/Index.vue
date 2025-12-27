<script setup lang="ts">
import ModalLink from '@/components/ModalLink.vue';
import NoResults from '@/components/NoResults.vue';
import PageHeader from '@/components/PageHeader.vue';
import Pagination from '@/components/Pagination.vue';
import { Button } from '@/components/ui/button';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import { deleteBySwal } from '@/composables/useSwal';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from "@/routes";
import { create as paymentCreate, destroy as paymentDelete, edit as paymentEdit,
    show as paymentShow
 } 
from '@/routes/admin/payments';
import { type BreadcrumbItem } from '@/types';
import { Plus, Search as SearchIcon, SquarePen, Trash2Icon, Eye } from 'lucide-vue-next';
import { ref } from 'vue';

interface Payment {
    id: number;
    invoice_id: number;
    user_id: number;
    amount: number;
    payment_date: string;
    payment_method: string;
    transaction_id: string;
    notes: string;
    created_at: string;
}

interface PaginationLink {
    url: string | null;
    label: string;
    active: boolean;
}

interface PaginatedPayments {
    data: Payment[];
    current_page: number;
    last_page: number;
    per_page: number;
    total?: number;
    from?: number;
    to?: number;
    links: PaginationLink[];
}

const props = defineProps<{
    payments: PaginatedPayments | null;
    flash?: { message?: string; type?: string };
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Payments',
        href: '',
    },
];

const searchQuery = ref('');
const filterMethod = ref('all');

const paymentMethods = [
    { value: 'credit_card', label: 'Credit Card' },
    { value: 'bank_transfer', label: 'Bank Transfer' },
    { value: 'paypal', label: 'PayPal' },
    { value: 'check', label: 'Check' },
    { value: 'cash', label: 'Cash' },
    { value: 'other', label: 'Other' },
];



const deletePayment = (payment: Payment) => {
    // Use project's shared deleteBySwal helper with resource-specific route helper
    deleteBySwal(paymentDelete({ payment: payment.id }).url, 'payment');
};

const formatCurrency = (amount: number): string => {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
    }).format(amount);
};

const formatDate = (date: string): string => {
    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
    });
};

const getStatusBadgeClass = (method: string): string => {
    const colors: { [key: string]: string } = {
        credit_card: 'bg-blue-100 text-blue-800',
        bank_transfer: 'bg-green-100 text-green-800',
        paypal: 'bg-yellow-100 text-yellow-800',
        check: 'bg-purple-100 text-purple-800',
        cash: 'bg-gray-100 text-gray-800',
        other: 'bg-indigo-100 text-indigo-800',
    };
    return colors[method] || 'bg-gray-100 text-gray-800';
};

const getMethodLabel = (method: string): string => {
    const methodObj = paymentMethods.find(m => m.value === method);
    return methodObj ? methodObj.label : method;
};
</script>

<template>
    <AppLayout>
        <div class="p-6">
            <PageHeader title="Payment Management" description="Manage all invoice payments" :breadcrumbs="breadcrumbs" />

            <!-- Top Actions Bar -->
            <div class="flex justify-between items-center w-full mb-6 gap-4">
                <ModalLink :href="paymentCreate().url" :variant="'save'">
                    <Plus class="w-4 h-4 mr-2" />
                    Add New
                </ModalLink>

            
            </div>

            <!-- Payments Table -->
            <div v-if="props.payments && props.payments.data.length > 0"
                class="overflow-x-auto bg-white dark:bg-gray-900 rounded-lg shadow">
                <Table>
                    <TableHeader>
                        <TableRow class="border-b border-gray-200">
                            <TableHead class="font-bold">Payment ID</TableHead>
                            <TableHead class="font-bold">Invoice ID</TableHead>
                            <TableHead class="font-bold">Amount</TableHead>
                            <TableHead class="font-bold">Payment Method</TableHead>
                            <TableHead class="font-bold">Payment Date</TableHead>
                            <TableHead class="font-bold">Transaction ID</TableHead>
                            <TableHead class="font-bold">Notes</TableHead>
                            <TableHead class="font-bold text-right">Actions</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow
                            v-for="payment in props.payments.data"
                            :key="payment.id"
                            class="border-b border-gray-100 hover:bg-gray-50 dark:hover:bg-gray-800"
                        >
                            <TableCell class="font-semibold text-gray-900">#{{ payment.id }}</TableCell>
                            <TableCell>
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                                    #{{ payment.invoice_id }}
                                </span>
                            </TableCell>
                            <TableCell class="font-bold text-green-600">
                                {{ formatCurrency(payment.amount) }}
                            </TableCell>
                            <TableCell>
                                <span :class="['px-3 py-1 rounded-full text-sm font-semibold', getStatusBadgeClass(payment.payment_method)]">
                                    {{ getMethodLabel(payment.payment_method) }}
                                </span>
                            </TableCell>
                            <TableCell class="text-gray-600">
                                {{ formatDate(payment.payment_date) }}
                            </TableCell>
                            <TableCell class="text-gray-600 font-mono text-sm">
                                {{ payment.transaction_id || '-' }}
                            </TableCell>
                            <TableCell class="text-gray-600 max-w-xs truncate">
                                {{ payment.notes || '-' }}
                            </TableCell>
                            <TableCell class="text-right">
                                <div class="flex justify-end gap-2">
                                    <ModalLink :href="paymentShow(payment.id).url" variant="show" :size="'sm'">
                                        <Eye class="w-4 h-4" />
                                    </ModalLink>
                                    <ModalLink :href="paymentEdit(payment.id).url" variant="edit" :size="'sm'">
                                        <SquarePen class="w-4 h-4" />
                                    </ModalLink>
                                    <Button
                                        @click="deletePayment(payment)"
                                        variant="outline"
                                        size="sm"
                                        class="text-red-600 border-red-600 hover:bg-red-50"
                                    >
                                        <Trash2Icon class="w-4 h-4" />
                                    </Button>
                                </div>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>

            <!-- No Results -->
            <NoResults v-else message="No payments found" />

            <!-- Pagination -->
            <div v-if="props.payments && props.payments.last_page > 1" class="mt-6">
                <Pagination :links="props.payments.links" />
            </div>
        </div>


    </AppLayout>
</template>
