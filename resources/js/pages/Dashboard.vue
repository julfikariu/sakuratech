<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Users, Briefcase, FileText, CreditCard } from 'lucide-vue-next';
import ProjectTable from '@/components/projects/ProjectTable.vue';
import InvoiceTable from '@/components/invoice/InvoiceTable.vue';
import type { PaginatedProjects } from '@/types/project';
import type { PaginatedInvoices } from '@/types/invoice';

interface Stats {
    total_clients: number;
    total_projects: number;
    total_invoices: number;
    total_users: number;
}

const props = defineProps<{
    stats: Stats;
    recent_projects: PaginatedProjects;
    recent_invoices: PaginatedInvoices;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-1 flex-col gap-4 p-4 pt-4">
            <!-- Stats Grid -->
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium"> Total Clients </CardTitle>
                        <Users class="h-4 w-4 text-muted-foreground" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">{{ stats.total_clients }}</div>
                    </CardContent>
                </Card>
                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium"> Total Projects </CardTitle>
                        <Briefcase class="h-4 w-4 text-muted-foreground" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">{{ stats.total_projects }}</div>
                    </CardContent>
                </Card>
                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium"> Total Invoices </CardTitle>
                        <FileText class="h-4 w-4 text-muted-foreground" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">{{ stats.total_invoices }}</div>
                    </CardContent>
                </Card>
                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium"> Total Users </CardTitle>
                        <CreditCard class="h-4 w-4 text-muted-foreground" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">{{ stats.total_users }}</div>
                    </CardContent>
                </Card>
            </div>

            <!-- Recent Activity using Reused Components -->
            <div class="flex flex-col gap-4">
                <div class="flex flex-col gap-2">
                    <h3 class="text-lg font-semibold tracking-tight">Recent Projects</h3>
                    <ProjectTable :projects="props.recent_projects" :show-client-column="true" />
                </div>

                <div class="flex flex-col gap-2">
                    <h3 class="text-lg font-semibold tracking-tight">Recent Invoices</h3>
                    <InvoiceTable :invoices="props.recent_invoices" :show-client-column="true" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
