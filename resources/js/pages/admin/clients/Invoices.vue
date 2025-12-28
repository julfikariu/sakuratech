<script setup lang="ts">
import PageHeader from '@/components/PageHeader.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from "@/routes";
import { index as clientsIndex } from '@/routes/admin/clients';
import { type BreadcrumbItem } from '@/types';
import TabMenu from './TabMenu.vue';

interface Invoice {
    id: number;
    inv_unique_id?: string;
    amount?: number;
    issue_date?: string | null;
    status?: string | null;
}

interface Client {
    id: number;
    company_name?: string;
}

const props = defineProps<{
    client: Client;
    invoices: Invoice[];
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

        <div class="mt-6 bg-white dark:bg-gray-900 rounded shadow">
            <div class="p-6">
                <h2 class="text-2xl font-semibold mb-4">Invoices</h2>
                <div v-if="props.invoices && props.invoices.length > 0" class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b">
                                <th class="py-3 px-4 text-left">Invoice ID</th>
                                <th class="py-3 px-4 text-left">Amount</th>
                                <th class="py-3 px-4 text-left">Issue Date</th>
                                <th class="py-3 px-4 text-left">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="inv in props.invoices" :key="inv.id" class="border-b hover:bg-gray-50 dark:hover:bg-gray-800">
                                <td class="py-3 px-4">{{ inv.inv_unique_id ?? ('#' + inv.id) }}</td>
                                <td class="py-3 px-4">${{ inv.amount?.toFixed(2) ?? '0.00' }}</td>
                                <td class="py-3 px-4">{{ inv.issue_date ?? '—' }}</td>
                                <td class="py-3 px-4">{{ inv.status ?? '—' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div v-else class="text-gray-500 py-8 text-center">No invoices found.</div>
            </div>
        </div>
    </div>
</AppLayout>
</template>