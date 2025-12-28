<script setup lang="ts">
import PageHeader from '@/components/PageHeader.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from "@/routes";
import { index as clientsIndex } from '@/routes/admin/clients';
import { type BreadcrumbItem } from '@/types';
import TabMenu from './TabMenu.vue';
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card"
import { Badge } from "@/components/ui/badge"
import StatusBadge from '@/components/StatusBadge.vue';

interface Client {
    id: number;
    user_id?: number;
    company_name?: string;
    phone?: string;
    address?: string;
    website?: string;
    status?: string;
    created_at?: string | null;
}

const props = defineProps<{
    client: Client;
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
            <PageHeader :title="`Client - ${props.client.company_name ?? ('#' + props.client.id)}`" description=""
                :breadcrumbs="breadcrumbs" />

            <TabMenu :client_id="props.client.id" />

            <div class="">
                <Card>
                    <CardHeader>
                        <CardTitle>Client Details</CardTitle>
                    </CardHeader>

                    <CardContent class=" space-y-4 text-sm">
                        <div class="grid grid-cols-3 gap-2">
                            <span class="text-muted-foreground">Company</span>
                            <span class="col-span-2 font-medium">
                                {{ props.client.company_name }}
                            </span>
                        </div>

                        <div class="grid grid-cols-3 gap-2">
                            <span class="text-muted-foreground">Phone</span>
                            <span class="col-span-2">{{ props.client.phone ?? '—' }}</span>
                        </div>

                        <div class="grid grid-cols-3 gap-2">
                            <span class="text-muted-foreground">Address</span>
                            <span class="col-span-2">{{ props.client.address ?? '—' }}</span>
                        </div>

                        <div class="grid grid-cols-3 gap-2">
                            <span class="text-muted-foreground">Website</span>
                            <span class="col-span-2 text-muted-foreground">{{ props.client.website ?? '—' }}</span>
                        </div>

                        <div class="grid grid-cols-3 gap-2 items-center">
                            <span class="text-muted-foreground">Status</span>
                            <span class="col-span-2">
                                <StatusBadge :status="props.client.status ?? '—'" />
                            </span>
                        </div>

                        <div class="grid grid-cols-3 gap-2">
                            <span class="text-muted-foreground">Created At</span>
                            <span class="col-span-2">
                                {{ props.client.created_at ?? '—' }}
                            </span>
                        </div>
                    </CardContent>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>
