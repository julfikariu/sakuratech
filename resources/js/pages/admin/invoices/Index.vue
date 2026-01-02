<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Plus } from 'lucide-vue-next';
import { dashboard } from "@/routes";
import { type BreadcrumbItem } from '@/types';
import PageHeader from '@/components/PageHeader.vue';
import { create as invoiceCreate } from '@/routes/admin/invoices';
import ModalLink from '@/components/ModalLink.vue';
import type { PaginatedInvoices } from '@/types/invoice';
import InvoiceTable from '@/components/invoice/InvoiceTable.vue';


interface Flash {
    message?: string;
    type?: string;
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

            <InvoiceTable :invoices="props.invoices" />
            
        </div>
    </AppLayout>
</template>