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
import type { Contact, PaginationLink } from '@/types/models';
import Pagination from '@/components/Pagination.vue';
import Search from './Search.vue';
import ModalLink from '@/components/ModalLink.vue';
import { show as contactShow, destroy as contactDestroy } from '@/routes/admin/contacts';
import { deleteBySwal } from '@/composables/useSwal';

interface PaginatedContacts {
    data: Contact[];
    current_page: number;
    last_page: number;
    per_page: number;
    total?: number;
    from?: number;
    to?: number;
    links: PaginationLink[];
}

const props = defineProps<{
    contacts: PaginatedContacts | null;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Contacts',
        href: '',
    },
];

</script>

<template>
    <AppLayout>

        <div class="p-6">
            <PageHeader title="All Contacts" description="" :breadcrumbs="breadcrumbs">
                <!-- <Button variant="save" @click="">
                    <Plus /> Add New
                </Button> -->
            </PageHeader>

            <div class="flex justify-between items-center w-full">
                <div></div>
                <div class="w-1/3">
                    <Search />
                </div>
            </div>

            <div v-if="props.contacts && props.contacts.data.length > 0"
                class="overflow-x-auto bg-white dark:bg-gray-900 rounded shadow">
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead>ID</TableHead>
                            <TableHead>Name</TableHead>
                            <TableHead>Email</TableHead>
                            <TableHead>Message</TableHead>
                            <TableHead>Submitted At</TableHead>
                            <TableHead class="text-right">Actions</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="item in props.contacts.data" :key="item.id">
                            <TableCell>{{ item.id }}</TableCell>
                            <TableCell>{{ item.name }}</TableCell>
                            <TableCell>{{ item.email }}</TableCell>
                            <TableCell>{{ item.message }}</TableCell>
                            <TableCell>{{ item.created_at }}</TableCell>
                            <TableCell class="text-right flex gap-2 justify-end">
                                <ModalLink :href="contactShow(item.id).url" :itemid="item.id" variant="details" :size="'sm'">
                                    <Eye class="w-4 h-4" />
                                </ModalLink>                               
                                <Button @click="deleteBySwal(contactDestroy({ contact: item.id }).url, 'contact')" variant="delete" size="sm">
                                    <Trash2Icon class="w-4 h-4" />
                                </Button>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
                <Pagination :from="Number(props.contacts.from)" :to="Number(props.contacts.to)"
                    :total="Number(props.contacts.total)" :links="props.contacts.links" class="mt-4" />
            </div>
            <NoResults v-else />

        </div>
    </AppLayout>
</template>
