<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import {
    Table,
    TableBody,
    TableCaption,
    TableCell,
    TableFooter,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table'
import { Button } from '@/components/ui/button';
import { Plus, Eye, SquarePen, Trash2Icon } from 'lucide-vue-next';
import { Link } from '@inertiajs/vue3';
import { dashboard } from "@/routes";
import { type BreadcrumbItem } from '@/types';
import PageHeader from '@/components/PageHeader.vue';
import NoResults from '@/components/NoResults.vue';
import type { Client, PaginationLink } from '@/types/models';
import Pagination from '@/components/Pagination.vue';
import { create as ClientCreate } from '@/routes/admin/clients';
import { show as ClientShow } from '@/routes/admin/clients';
import Search from './Search.vue';
import ModalLink from '@/components/ModalLink.vue';

interface Flash {
    message?: string;
    type?: string;
}

interface PaginatedClients {
    data: Client[];
    current_page: number;
    last_page: number;
    per_page: number;
    total?: number;
    from?: number;
    to?: number;
    links: PaginationLink[];
}

const props = defineProps<{
    clients: PaginatedClients | null;
    flash?: Flash;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Clients',
        href: '',
    },
];


</script>

<template>
    <AppLayout>

        <div class="p-6">
            <PageHeader title="All Clients" description="" :breadcrumbs="breadcrumbs">
                <!-- <Button variant="save" @click="">
                    <Plus /> Add New
                </Button> -->
            </PageHeader>

            <div class="flex justify-between items-center w-full">
                <Link  :href="ClientCreate().url">
                    <Button variant="save" >
                        <Plus /> Add New
                    </Button>
                </Link>
                <div class="w-1/3">
                    <Search />
                </div>
            </div>

            <div v-if="props.clients && props.clients.data.length > 0"
                class="overflow-x-auto bg-white dark:bg-gray-900 rounded shadow">
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead>ID</TableHead>
                            <TableHead>Company Name</TableHead>
                            <TableHead>Phone</TableHead>
                            <TableHead>Address</TableHead>
                            <TableHead>Website</TableHead>
                            <TableHead class="text-right">Actions</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="item in props.clients.data" :key="item.id">
                            <TableCell>{{ item.id }}</TableCell>
                            <TableCell>{{ item.company_name }}</TableCell>
                            <TableCell>{{ item.phone }}</TableCell>
                            <TableCell>{{ item.address }}</TableCell>
                            <TableCell>{{ item.website }}</TableCell>
                            <TableCell class="text-right flex gap-2 justify-end">

                                <ModalLink :href="ClientShow(item.id).url" :itemid="item.id"
                                    variant="assign" :size="'sm'">
                                    <Eye class="w-4 h-4" />
                                </ModalLink>
                                <Button variant="edit" size="sm">
                                    <SquarePen class="w-4 h-4" />
                                </Button>
                                <Button variant="delete" size="sm">
                                    <Trash2Icon class="w-4 h-4" />
                                </Button>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
                <Pagination :from="Number(props.clients.from)" :to="Number(props.clients.to)"
                    :total="Number(props.clients.total)" :links="props.clients.links" class="mt-4" />
            </div>
            <NoResults v-else />
        </div>
    </AppLayout>
</template>