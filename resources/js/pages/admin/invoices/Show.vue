<script setup lang="ts">
import PageHeader from '@/components/PageHeader.vue';
import Badge from '@/components/ui/badge/Badge.vue';
import Button from '@/components/ui/button/Button.vue';
import {
    Card,
    CardContent,
    CardDescription,
    CardTitle
} from '@/components/ui/card';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from "@/routes";
import { index as invoiceIndex } from '@/routes/admin/invoices';
import { type BreadcrumbItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { Printer, Mail, ArrowLeft } from 'lucide-vue-next';
import { computed } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Invoices',
        href: invoiceIndex().url,
    },
    {
        title: 'Details',
        href: '',
    },
];

interface InvoiceItem {
    id: string | null;
    description: string;
    qty: number;
    unit: string;
    rate: number;
    total: number;
}

interface Invoice {
    id: number | null;
    client: string | null;
    project_id?: number;
    issue_date: string;
    due_date: string;
    amount: number;
    status: string;
    notes?: string;
}

interface Client {
    id: number;
    company_name?: string;
    address?: string;
}

interface Props {
    invoice: Invoice;
    invoiceItems?: InvoiceItem[];
    client?: Client | null;
}

const props = defineProps<Props>();

const invoiceItems = computed<InvoiceItem[]>(() => (
    (props.invoiceItems && props.invoiceItems.length > 0)
        ? props.invoiceItems.map((i: any) => ({
            id: i.id ?? null,
            description: i.description ?? '',
            qty: i.quantity ?? i.qty ?? 1,
            unit: i.unit ?? '$',
            rate: i.price ?? i.rate ?? 0,
            total: i.total ?? ((i.quantity ?? i.qty ?? 1) * (i.price ?? i.rate ?? 0)),
          }))
        : []
));

const invoiceTotal = computed(() => {
    return invoiceItems.value.reduce((s, item) => s + ((Number(item.qty) || 0) * (Number(item.rate) || 0)), 0);
});

</script>

<template>
    <AppLayout>
        <div class="p-6">
            <PageHeader title="Invoice Details" description="" :breadcrumbs="breadcrumbs" />

            <div class="">
                <Card class="w-full">
                    <CardContent>

                        <div class="flex justify-between items-center border-b pb-4 mb-4">
                            <div class="">
                                <CardTitle class="text-2xl font-bold py-3">Invoice</CardTitle>
                                <div class="text-m text-gray-600">{{ props.invoice.invoice_id ?? ('INV-' + (props.invoice.id ?? '')) }}</div>
                            </div>
                            <div class="">
                                <span class="inline-block px-4 py-2 text-gray-500 rounded text-2xl font-semibold">{{ (props.invoice.status || 'DRAFT').toUpperCase() }}</span>
                            </div>
                        </div>

                        <div class="flex justify-between items-start mb-6">
                            <div class="">
                                <CardTitle class="text-xl font-bold py-3">Sakura Soft Tech</CardTitle>
                                <CardDescription class="text-sm text-gray-600">140/12 , Tokiyo</CardDescription>
                                <CardDescription class="text-sm text-gray-600">City, State, ZIP</CardDescription>
                                <CardDescription class="text-sm text-gray-600">Japan</CardDescription>
                            </div>
                            <div class="text-right">
                                <CardTitle class="text-xl font-bold py-3">Invoice To</CardTitle>
                                <CardDescription class="text-sm text-gray-600">{{ props.client?.company_name ?? ('Client #' + props.invoice.client) }}</CardDescription>
                                <CardDescription class="text-sm text-gray-600">&nbsp; {{ props.invoice.client }}</CardDescription>
                                <CardDescription class="text-sm text-gray-600">&nbsp;{{  props.client?.address }}</CardDescription>
                                <CardDescription class="text-sm text-gray-600">&nbsp;</CardDescription>
                            </div>
                        </div>

                        <div class=" flex flex-row justify-between gap-6 mt-8 mb-10">

                            <!-- Left: Dates -->
                            <div class="space-y-4 w-1/2">

                                <div class="flex flex-row justify-between gap-6">
                                    <!-- Left: Dates -->
                                    <div class="space-y-4 w-full">
                                        <div class="flex items-center gap-3">
                                            <div class="w-24 text-muted-foreground">Invoice Date</div>
                                            <div class="w-40">{{ props.invoice.issue_date }}</div>
                                        </div>

                                        <div class="flex items-center gap-3">
                                            <div class="w-24 text-muted-foreground">Due Date</div>
                                            <div class="w-40">{{ props.invoice.due_date }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right: Payment Summary -->
                            <div class="space-y-4 w-1/2 md:text-right">
                                <div class="flex md:justify-end items-center gap-3">
                                    <div class="w-24 text-muted-foreground">Payments</div>
                                    <span class="font-medium w-24 text-gray-700">$0.00</span>
                                </div>

                                <div class="flex md:justify-end items-center gap-3">
                                    <div class="w-24 text-muted-foreground">Balance Due</div>
                                    <div class="w-24">
                                        <Badge variant="destructive" class=" px-4 py-1 text-sm">
                                            ${{ invoiceTotal.toFixed(2) }}
                                        </Badge>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Table Header -->
                        <div class="overflow-x-auto mb-4">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="border-b border-gray-300">
                                        <th class="text-center py-3 px-4 font-semibold text-gray-700 w-12"></th>
                                        <th class="text-left py-3 px-4 font-semibold text-gray-700">Description</th>
                                        <th class="text-center py-3 px-4 font-semibold text-gray-700 w-20">Qty</th>
                                        <th class="text-center py-3 px-4 font-semibold text-gray-700 w-20">Unit</th>
                                        <th class="text-right py-3 px-4 font-semibold text-gray-700 w-24">Rate</th>
                                        <th class="text-right py-3 px-4 font-semibold text-gray-700 w-24">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(invitem, index) in invoiceItems" :key="invitem.id ?? index" class="border-b border-gray-200 hover:bg-gray-50">
                                        <td class="py-3 px-4 text-center">&nbsp;</td>
                                        <td class="py-3 px-4">{{ invitem.description }}</td>
                                        <td class="py-3 px-4 text-center">{{ invitem.qty }}</td>
                                        <td class="py-3 px-4 text-center">{{ invitem.unit }}</td>
                                        <td class="py-3 px-4 text-right">{{ Number(invitem.rate).toFixed(2) }}</td>
                                        <td class="py-3 px-2 text-right font-semibold text-gray-700 bg-gray-100">{{ (invitem.qty * invitem.rate).toFixed(2) }}</td>
                                    </tr>

                                    <tr v-if="invoiceItems.length === 0" class="border-b border-gray-200">
                                        <td colspan="6" class="py-4 px-4 text-center text-gray-500">No items</td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="flex justify-end mt-6">
                                <div class="w-1/3">
                                    <div class="flex justify-between items-center pt-2 mt-2">
                                        <span class="text-gray-900 font-bold">Total:</span>
                                        <span class="font-bold text-gray-900">${{ invoiceTotal.toFixed(2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Invoice Terms -->
                        <div class="mt-8 mb-8">
                            <div class="mb-2 block">Invoice Terms</div>
                            <div class="h-24 w-80 p-3 border rounded bg-gray-50 text-sm text-gray-700">
                                {{ props.invoice.notes || '—' }}
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-between border-t pt-2 mt-6">
                            <Link :href="invoiceIndex().url">
                                <Button type="button" variant="default" >                                
                                   <ArrowLeft class="w-4 h-4 mr-2" /> Back
                                </Button>
                            </Link>
                            <div class="space-x-2">
                                <Button type="button" variant="primary">
                                  <Printer class="w-4 h-4 mr-2" /> Print
                                </Button>
                                <Button type="button" variant="save" >
                                  <Mail class="w-4 h-4 mr-2" /> Send Invoice
                                </Button>
                            </div>
                        </div>

                    </CardContent>
                </Card>

            </div>

        </div>
    </AppLayout>
</template>
