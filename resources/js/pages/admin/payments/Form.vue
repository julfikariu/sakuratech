<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import Modal from '@/components/Modal.vue';
import { Button } from '@/components/ui/button';
import Input from '@/components/ui/input/Input.vue';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Textarea } from '@/components/ui/textarea';
import { close, modal } from '@/composables/useModal';
import { store as paymentStore } from '@/routes/admin/payments';
import { update as paymentUpdate } from '@/routes/admin/payments';
import { useForm } from '@inertiajs/vue3';
import { CalendarDays, LoaderCircle, Save, X } from 'lucide-vue-next';

interface Invoice { id: number; label: string }
interface Props { 
    invoices: Invoice[];
    payment: any;
    is_edit: boolean 
}

const props = defineProps<Props>();

const form = useForm({
    id: props.payment?.id || 0,
    invoice_id: props.payment?.invoice_id || null,
    amount: props.payment?.amount || null,
    payment_date: props.payment?.payment_date,
    payment_method: props.payment?.payment_method || 'credit_card',
    transaction_id: props.payment?.transaction_id || '',
    notes: props.payment?.notes || '',
});

const paymentMethods = ['Credit Card','Bank Transfer','PayPal','Check','Cash','Other'];

function submitForm() {
    if (!props.is_edit){
        form.put(paymentUpdate({ payment: form.id }).url(), {
            onSuccess: () => {
                form.reset();
                close();
                modal.value = null;
            },
        });
        return;
    }
    form.post(paymentStore.url(), {
        onSuccess: () => {
            form.reset();
            close();
            modal.value = null;
        },
    });
}
</script>

<template>
 <Modal :show="true" :size="'lg'" title="Add Payment" @close="close">
    <div class="pb-6">
            <form @submit.prevent="submitForm">
                <div class="grid gap-6">

                    <div class="flex items-center">
                        <Label class="w-1/7 justify-end mr-4">Invoice : </Label>
                        <div class="w-6/7">
                            <Select v-model="form.invoice_id" name="invoice_id" >
                                <SelectTrigger class="w-full">
                                    <SelectValue placeholder="Select invoice" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem v-for="inv in props.invoices" :key="inv.id" :value="inv.id">{{ inv.label }}</SelectItem>
                                </SelectContent>
                            </Select>
                            <InputError :message="form.errors.invoice_id" />
                        </div>
                    </div>

                    <div class="flex items-center">
                        <Label class="w-1/7 justify-end mr-4">Amount : </Label>
                        <div class="w-6/7">
                            <div class="relative">
                                <span class="absolute left-4 top-2.5 text-gray-500">$</span>
                                <input
                                    v-model.number="form.amount"
                                    type="number"
                                    step="0.01"
                                    class="w-full pl-8 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="0.00"
                                />
                            </div>
                            <InputError :message="form.errors.amount" />
                        </div>
                    </div>

                    <div class="flex items-center">
                        <Label class="w-1/7 justify-end mr-4">Payment Date :</Label>
                        <div class="w-6/7">
                            <div class="flex items-center border rounded">
                                <span class="p-2 h-9 bg-gray-100 text-sm text-gray-600">
                                    <CalendarDays class="w-4 h-4 inline-bloc" />
                                </span>
                                <input v-model="form.payment_date" type="date" class="w-full px-4 py-2" />
                            </div>
                            <InputError :message="form.errors.payment_date" />
                        </div>
                    </div>

                    <div class="flex items-center">
                        <Label class="w-1/7 justify-end mr-4">Payment Method :</Label>
                        <div class="w-6/7">
                            <Select v-model="form.payment_method" name="payment_method" >
                                <SelectTrigger class="w-full">
                                    <SelectValue placeholder="Select method" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem v-for="m in paymentMethods" :key="m" :value="m">{{ m }}</SelectItem>
                                </SelectContent>
                            </Select>
                            <InputError :message="form.errors.payment_method" />
                        </div>
                    </div>

                    <div class="flex items-center">
                        <Label class="w-1/7 justify-end mr-4">Transaction ID :</Label>
                        <div class="w-6/7">
                            <Input v-model="form.transaction_id" placeholder="e.g., TXN-123456" />
                            <InputError :message="form.errors.transaction_id" />
                        </div>
                    </div>

                    <div class="flex items-start">
                        <Label class="w-1/7 justify-end mr-4">Notes :</Label>
                        <div class="w-6/7">
                            <Textarea v-model="form.notes" rows="4"></Textarea>
                            <InputError :message="form.errors.notes" />
                        </div>
                    </div>

                    <div class="flex items-center">
                        <Label class="w-1/8 justify-end mr-4"></Label>
                        <div class="flex gap-2 w-1/12">
                            <Button type="submit"  variant="save" :disabled="form.processing">
                                <LoaderCircle v-if="form.processing" class="w-4 h-4 animate-spin mr-2" />
                                <Save v-else class="w-4 h-4" /> Create
                            </Button>
                            <Button type="button" class="cursor-pointer" variant="secondary"
                                @click.prevent="close">
                                <X class="w-4 h-4" />  Cancel
                            </Button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
 </Modal>
</template>