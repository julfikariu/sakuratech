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
import Input from '@/components/ui/input/Input.vue';
import InputError from '@/components/InputError.vue';
import Label from '@/components/ui/label/Label.vue';
import { Textarea } from '@/components/ui/textarea';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from "@/routes";
import {
    index as invoiceIndex
} from '@/routes/admin/invoices';
import { type BreadcrumbItem } from '@/types';
import { useForm } from '@inertiajs/vue3';
import { Plus, SaveIcon, X } from 'lucide-vue-next';
import { computed, ref, watch } from 'vue';
import { update as invoiceUpdate } from '@/routes/admin/invoices';


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

interface Invoice {
    id: number | null;
    client_id: number;
    project_id: number;
    issue_date: string;
    due_date: string;
    amount: number;
    status: string;
    notes: string;
}

interface InvoiceItem {
    id: string | null;
    description: string;
    qty: number;
    unit: string;
    rate: number;
    total: number;
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

const form = useForm({
    id: props.invoice.id || 0,
    client_id: props.invoice.client_id || null,
    project_id: props.invoice.project_id || null,
    issue_date: props.invoice.issue_date || '',
    due_date: props.invoice.due_date || '',
    amount: props.invoice.amount || 0,
    status: (props.invoice.status && typeof props.invoice.status === 'string') ? props.invoice.status.toLowerCase() : 'draft',
    notes: props.invoice.notes || '',
    items: props.invoiceItems || [],
});

// Initialize invoiceItems from props (map backend fields to UI fields)
const invoiceItems = ref<InvoiceItem[]>(
    (props.invoiceItems && props.invoiceItems.length > 0)
        ? props.invoiceItems.map((i: any) => ({
            id: i.id ?? null,
            description: i.description ?? '',
            qty: i.quantity ?? i.qty ?? 1,
            unit: i.unit ?? '$',
            rate: i.price ?? i.rate ?? 0,
            total: i.total ?? ((i.quantity ?? i.qty ?? 1) * (i.price ?? i.rate ?? 0)),
          }))
        : [
            {
                id: null,
                description: 'Item',
                qty: 1,
                unit: '$',
                rate: 0,
                total: 0,
            },
          ]
);

const addItem = () => {
    invoiceItems.value.push({
        id: null,
        description: '',
        qty: 1,
        unit: '$',
        rate: 0,
        total: 0,
    });
};

const invoiceTotal = computed(() => {
    return invoiceItems.value.reduce((s, item) => s + ((Number(item.qty) || 0) * (Number(item.rate) || 0)), 0);
});

// items total how to calculate
const itemTotal = (item: InvoiceItem) => {
    return (Number(item.qty) || 0) * (Number(item.rate) || 0);
};

watch(invoiceItems, (newItems) => {
    // Update totals for each item
    newItems.forEach((item) => {
        item.total = itemTotal(item);
    });
}, { deep: true });


// keep form.amount in sync
watch(invoiceTotal, (val) => {
    form.amount = Number(val.toFixed(2));
});

function save() {
    // prepare items payload
    form.items = invoiceItems.value.map(i => ({
        id: i.id,
        description: i.description,
        qty: i.qty,
        unit: i.unit,
        rate: i.rate,
        total: i.total,
    }));

    form.put(invoiceUpdate.url(form.id), {
        preserveScroll: true,
        onSuccess: () => {
            // optional: show notification or redirect handled by controller
        }
    });
}

const removeItem = (index: number) => {
  invoiceItems.value.splice(index, 1);
};

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
                                            <Input v-model="form.issue_date" type="date" class="w-40" />
                                            <InputError :message="form.errors.issue_date" />
                                        </div>

                                        <div class="flex items-center gap-3">
                                            <Label class="w-24 text-muted-foreground">Due Date</Label>
                                            <Input v-model="form.due_date" type="date" class="w-40" />
                                            <InputError :message="form.errors.due_date" />
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
                                    <tr  v-for="(invitem, index) in invoiceItems" :key="invitem.id ?? index"  class="border-b border-gray-200 hover:bg-gray-50">
                                        <input type="hidden" name="item_id" :value="invitem.id"/>
                                        <td class="py-3 px-4 text-center">
                                            <Button  v-if="index !== 0"  @click="removeItem(index)" variant="delete" size="sm" title="Delete">
                                                <X class="w-4 h-4" />
                                            </Button>
                                        </td>
                                        <td class="py-3 px-4">
                                            <input type="text" v-model="invitem.description"
                                                class="w-full px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                placeholder="Item description" />
                                            <InputError :message="form.errors['items.' + index + '.description']" />
                                        </td>
                                        <td class="py-3 px-4">
                                            <input  type="number" v-model="invitem.qty"
                                                class="w-full px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 text-center"
                                                placeholder="0" />
                                        </td>
                                        <td class="py-3 px-4">
                                            <input type="text" v-model="invitem.unit"
                                                class="w-full px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 text-center"
                                                placeholder="$" />
                                        </td>
                                        <td class="py-3 px-4">
                                            <input type="number" v-model="invitem.rate"
                                                class="w-full px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 text-right"
                                                placeholder="0.00" />
                                        </td>                                        
                                        <td class="py-3 px-2 text-right font-semibold text-gray-700 bg-gray-100">
                                            {{ (invitem.qty * invitem.rate).toFixed(2) }}
                                        </td>
                                       
                                    </tr>
                                </tbody>
                            </table>

                            <div class="flex justify-start mt-4">
                                <Button @click="addItem" type="button" variant="edit" class="gap-0">
                                    <Plus class="w-4 h-4 mr-2" /> Add New
                                </Button>
                            </div> 


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
                            <Label class="mb-2 block">Invoice Terms</Label>
                            <Textarea v-model="form.notes" class="h-24 w-80" placeholder="Add payment terms, notes, or conditions" />
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-between border-t pt-2 mt-6">
                            <Button type="button" variant="outline" class="px-6 py-2">                                
                                Exit Editing Mode
                            </Button>
                            <Button type="button" variant="save" class="gap-0" :disabled="form.processing" @click.prevent="save">
                               <SaveIcon class="w-4 h-4 mr-2" /> <span v-if="!form.processing">Save Changes</span>
                               <span v-else class="opacity-70">Saving...</span>
                            </Button>
                        </div>


                    </CardContent>
                </Card>

            </div>


        </div>
    </AppLayout>
</template>