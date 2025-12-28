<script setup lang="ts">
import Modal from '@/components/Modal.vue';
import { close } from '@/composables/useModal';
import { Button } from '@/components/ui/button';
import {
    Table,
    TableBody,
    TableCell,
    TableRow,
} from '@/components/ui/table';
import { SquarePen, X } from 'lucide-vue-next';
import { edit as paymentEdit } from '@/routes/admin/payments';
import ModalLink from '@/components/ModalLink.vue';

interface Payment {
    id: number;
    invoice_id: number;
    amount: number;
    payment_date: string;
    payment_method: string;
    transaction_id: string;
    notes: string | null;
    created_at: string | null;
}

const props = defineProps<{
    payment: Payment;
}>();
</script>

<template>
    <Modal :show="true" :size="'md'" :title="`Payment Details - #${props.payment.id}`" @close="close">
        <div class="px-4">
            <div class="overflow-x-auto bg-white dark:bg-gray-900 rounded">
                <Table>
                    <TableBody>
                        <TableRow>
                            <TableCell class="py-2 pl-0 font-semibold text-gray-700 w-2/10">Payment ID</TableCell>
                            <TableCell class="py-2 pl-0 text-center">:</TableCell>
                            <TableCell class="py-2 pl-0">{{ props.payment.id }}</TableCell>
                        </TableRow>
                        <TableRow>
                            <TableCell class="py-2 pl-0 font-semibold text-gray-700">Invoice ID</TableCell>
                            <TableCell class="py-2 pl-0 text-center">:</TableCell>
                            <TableCell class="py-2 pl-0">{{ props.payment.invoice_id }}</TableCell>
                        </TableRow>
                        <TableRow>
                            <TableCell class="py-2 pl-0 font-semibold text-gray-700">Payment</TableCell>
                            <TableCell class="py-2 pl-0 text-center">:</TableCell>
                            <TableCell class="py-2 pl-0">${{ props.payment.amount.toFixed(2) }} </TableCell>
                        </TableRow>
                    
                        <TableRow>
                            <TableCell class="py-2 pl-0 font-semibold text-gray-700">Payment Date</TableCell>
                            <TableCell class="py-2 pl-0 text-center">:</TableCell>
                            <TableCell class="py-2 pl-0">{{ props.payment.payment_date }}</TableCell>
                        </TableRow>
                        <TableRow>
                            <TableCell class="py-2 pl-0 font-semibold text-gray-700">Payment Method</TableCell>
                            <TableCell class="py-2 pl-0 text-center">:</TableCell>
                            <TableCell class="py-2 pl-0">{{ props.payment.payment_method }}</TableCell>
                        </TableRow>
                        <TableRow>
                            <TableCell class="py-2 pl-0 font-semibold text-gray-700">Transaction ID</TableCell>
                            <TableCell class="py-2 pl-0 text-center">:</TableCell>
                            <TableCell class="py-2 pl-0">{{ props.payment.transaction_id }}</TableCell>
                        </TableRow>
                        <TableRow>
                            <TableCell class="py-2 pl-0 font-semibold text-gray-700">Notes</TableCell>
                            <TableCell class="py-2 pl-0 text-center">:</TableCell>
                            <TableCell class="py-2 pl-0">{{ props.payment.notes || 'N/A' }}</TableCell>
                        </TableRow>

                        <TableRow>
                            <TableCell class="py-2 pl-0 font-semibold text-gray-700">Created At</TableCell>
                            <TableCell class="py-2 pl-0 text-center">:</TableCell>
                            <TableCell class="py-2 pl-0">{{ props.payment.created_at ?? '-' }}</TableCell>
                        </TableRow>
                    </TableBody>
                </Table>                
            </div>            
        </div>
        <template #footer>
            <div class="flex justify-end gap-3">  
                <ModalLink :href="paymentEdit(payment.id).url" variant="reset" :size="'sm'">
                    <SquarePen class="w-4 h-4" /> Update
                </ModalLink>             
              
                <Button @click="close" variant="secondary" class="cursor-pointer">
                    <X class="w-4 h-4" /> Close
                </Button>
            </div>
        </template>
    </Modal>
</template>