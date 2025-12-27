<script setup lang="ts">
import Modal from '@/components/Modal.vue';
import { close } from '@/composables/useModal';
import { Button } from '@/components/ui/button';


interface Payment {
    id: number;
    invoice_id: number;
    amount: number;
    payment_date: string;
    payment_method: string;
    transaction_id: string;
    notes: string | null;
}

const props = defineProps<{
    payment: Payment;
}>();

</script>

<template>
    <Modal :show="true" :size="'md'" :title="`Payment Details - #${props.payment.id}`" @close="close">
        <div class="pb-6">
            <div class="space-y-4">
                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Payment Information</h3>
                    <div class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        <p><strong>Payment ID:</strong> {{ props.payment.id }}</p>
                        <p><strong>Invoice ID:</strong> {{ props.payment.invoice_id }}</p>
                        <p><strong>Amount:</strong> ${{ props.payment.amount.toFixed(2) }}</p>
                        <p><strong>Payment Date:</strong> {{ props.payment.payment_date }}</p>
                        <p><strong>Payment Method:</strong> {{ props.payment.payment_method }}</p>
                        <p><strong>Transaction ID:</strong> {{ props.payment.transaction_id }}</p>
                        <p><strong>Notes:</strong> {{ props.payment.notes || 'N/A' }}</p>
                    </div>
                </div>
            </div>
            <div class="mt-6 flex justify-end">
                
                <Button @click="close">Close</Button>
            </div>
        </div>
    </Modal>
</template>