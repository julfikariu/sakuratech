<script setup lang="ts">
import PageHeader from '@/components/PageHeader.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from "@/routes";
import {
    index as invoiceIndex
} from '@/routes/admin/invoices';
import { type BreadcrumbItem } from '@/types';
import { computed, ref, Text } from 'vue';
import {
    Card,
    CardAction,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from '@/components/ui/card'
import Label from '@/components/ui/label/Label.vue';
import Input from '@/components/ui/input/Input.vue';
import Badge from '@/components/ui/badge/Badge.vue';
import Button from '@/components/ui/button/Button.vue';
import { Textarea } from '@/components/ui/textarea';
import { X, SaveIcon, Plus } from 'lucide-vue-next';




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
        title: 'Edit',
        href: '',
    },
];

// Form data
const invoiceNumber = ref('INV-000001');
const invoiceDate = ref(new Date().toISOString().split('T')[0]);
const dueDate = ref('');
const clientName = ref('');
const clientEmail = ref('');
const invoiceItems = ref<InvoiceItem[]>([
    {
        id: '1',
        description: 'Item',
        qty: null,
        unit: '$',
        rate: null,
    },
]);

interface Invoice {
    id: number;
    client_id: number;
    project_id: number;
    issue_date: string;
    due_date: string;
    status: string;
    notes: string;
}

interface InvoiceItem {
    id: string;
    description: string;
    qty: number | null;
    unit: string;
    rate: number | null;
}

interface Client {
    id: number;
    company_name: string;
}



interface Props { 
    invoice: Invoice[];
    clients: Client[];
    invoiceItems?: InvoiceItem[];
    
}

const props = defineProps<Props>();

</script>


<template>
    <AppLayout>
        <div class="p-6">
            <PageHeader title="Invoice Edit" description="" :breadcrumbs="breadcrumbs" />

            <div class="">
                <Card class="w-full">
                    <CardContent>

                          <div class="flex justify-between items-center border-b pb-4 mb-4">
                            <div class="">
                                <CardTitle class="text-2xl font-bold py-3">Invoice</CardTitle>
                                <div class="text-m text-gray-600">#INV-01212121</div>
                            </div>
                            <div class="">
                                <span
                                    class="inline-block px-4 py-2  text-gray-500 rounded text-2xl font-semibold">DRAFT</span>
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
                                <CardDescription class="text-sm text-gray-600">First Applications INC</CardDescription>
                                <CardDescription class="text-sm text-gray-600">140/12 , Tokiyo</CardDescription>
                                <CardDescription class="text-sm text-gray-600">City, State, ZIP</CardDescription>
                                <CardDescription class="text-sm text-gray-600">Japan</CardDescription>
                            </div>
                        </div>



                        <div class=" flex flex-row justify-between gap-6 mt-8 mb-10">

                            <!-- Left: Dates -->
                            <div class="space-y-4 w-1/2">

                                <div class="flex flex-row justify-between gap-6">
                                   <!-- Left: Dates -->
                                    <div class="space-y-4 w-full">
                                        <div class="flex items-center gap-3">
                                            <Label class="w-24 text-muted-foreground">Invoice Date</Label>
                                            <Input v-model="invoiceDate" type="date" class="w-40" />
                                        </div>

                                        <div class="flex items-center gap-3">
                                            <Label class="w-24 text-muted-foreground">Due Date</Label>
                                            <Input v-model="dueDate" type="date" class="w-40" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right: Payment Summary -->
                            <div class="space-y-4 w-1/2 md:text-right">
                                <div class="flex md:justify-end items-center gap-3">
                                    <Label class="w-24 text-muted-foreground">Payments</Label>
                                    <span class="font-medium w-24 text-gray-700">$0.00</span>
                                </div>

                                <div class="flex md:justify-end items-center gap-3">
                                    <Label class="w-24 text-muted-foreground">Balance Due</Label>
                                    <div class="w-24">
                                        <Badge variant="destructive" class=" px-4 py-1 text-sm">
                                            $0.00
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
                                    <tr  class="border-b border-gray-200 hover:bg-gray-50">
                                        <td class="py-3 px-4 text-center">
                                            <Button variant="delete" size="sm" title="Delete">
                                                <X class="w-4 h-4" />
                                            </Button>
                                        </td>
                                        <td class="py-3 px-4">
                                            <input type="text"
                                                class="w-full px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                placeholder="Item description" />
                                        </td>
                                        <td class="py-3 px-4">
                                            <input  type="number"
                                                class="w-full px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 text-center"
                                                placeholder="0" />
                                        </td>
                                        <td class="py-3 px-4">
                                            <input type="text"
                                                class="w-full px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 text-center"
                                                placeholder="$" />
                                        </td>
                                        <td class="py-3 px-4">
                                            <input type="number"
                                                class="w-full px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 text-right"
                                                placeholder="0.00" />
                                        </td>
                                        <td class="py-3 px-2 text-right font-semibold text-gray-700 bg-gray-100">
                                            $0.00
                                        </td>
                                       
                                    </tr>
                                </tbody>
                            </table>

                            <div class="flex justify-start mt-4">
                                <Button type="button" variant="edit" class="gap-0">
                                    <Plus class="w-4 h-4 mr-2" /> Add New
                                </Button>
                            </div> 


                            <div class="flex justify-end mt-6">
                                <div class="w-1/3">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-gray-700 font-medium">Subtotal:</span>
                                        <span class="font-semibold text-gray-700">$0.00</span>
                                    </div>
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-gray-700 font-medium">Tax (0%):</span>
                                        <span class="font-semibold text-gray-700">$0.00</span>
                                    </div>
                                    <div class="flex justify-between items-center border-t pt-2 mt-2">
                                        <span class="text-gray-900 font-bold">Total:</span>
                                        <span class="font-bold text-gray-900">$0.00</span>
                                    </div>
                                </div> 
                            </div>
                        </div>


                        <!-- Invoice Terms -->
                        <div class="mt-8 mb-8">
                            <Label class="mb-2 block">Invoice Terms</Label>
                            <Textarea class="h-24 w-80" placeholder="Add payment terms, notes, or conditions" />
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-between border-t pt-2 mt-6">
                            <Button type="button" variant="outline" class="px-6 py-2">                                
                                Exit Editing Mode
                            </Button>
                            <Button type="submit" variant="save" class="gap-0">
                               <SaveIcon class="w-4 h-4 mr-2" /> Save Changes
                            </Button>
                        </div>


                    </CardContent>
                </Card>

            </div>


        </div>
    </AppLayout>
</template>