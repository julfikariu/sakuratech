<script setup lang="ts">
import PageHeader from '@/components/PageHeader.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from "@/routes";
import { index as clientsIndex } from '@/routes/admin/clients';
import { type BreadcrumbItem } from '@/types';
import TabMenu from './TabMenu.vue';
import InvoiceList from '@/components/invoice/InvoiceList.vue';
import type { PaginatedInvoices } from '@/types/invoice';

interface Client {
    id: number;
    company_name?: string;
}

const props = defineProps<{
    client: Client;
    invoices: PaginatedInvoices | null;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Clients',
        href: clientsIndex().url,
    },
    {
        title: props.client.company_name ?? `Client #${props.client.id}`,
        href: '',
    },
];
</script>

<template>
<AppLayout>
    <div class="p-6">
        <PageHeader :title="`Client - ${props.client.company_name ?? ('#' + props.client.id)}`" description="" :breadcrumbs="breadcrumbs" />

        <TabMenu :client_id="props.client.id" />

        <div class=" bg-white dark:bg-gray-900 rounded shadow">
            <div class="p-6">
                <h2 class="text-2xl font-semibold mb-4">Invoices</h2>

                <InvoiceList :invoices="props.invoices" :showClientColumn="false" />
                
            </div>
        </div>
    </div>
</AppLayout>
</template>