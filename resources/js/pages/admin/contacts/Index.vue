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
import { Plus, Home, ChevronRight } from 'lucide-vue-next';
import { Link } from '@inertiajs/vue3';
import { dashboard } from "@/routes";
import { type BreadcrumbItem } from '@/types';
import PageHeader from '@/components/PageHeader.vue';

interface Contacts {
    id: number;
    name: string;
    email: string;
    message: string;
    created_at: string;
}

const props = defineProps<{
    contacts: Contacts[];
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Contacts',
        href: '/admin/contacts',
    },
];

function deleteContact(id: number) {
    if (!confirm('Are you sure you want to delete this contact?')) return;
    Inertia.delete(`/admin/contacts/${id}`);
}

</script>

<template>
    <AppLayout> 
        
        <div class="p-6">
            <PageHeader 
                title="All Contacts" 
                description="Controlpanel"
                :breadcrumbs="breadcrumbs"
            >
                <Button variant="save" @click="">
                       <Plus /> Add New
                </Button>
                
            </PageHeader>

            <Table>
                <TableCaption>List of contacts submitted via the contact form.</TableCaption>
                <TableHeader>
                    <TableRow>
                        <TableHead>ID</TableHead>
                        <TableHead>Name</TableHead>
                        <TableHead>Email</TableHead>
                        <TableHead>Message</TableHead>
                        <TableHead>Submitted At</TableHead>
                        <TableHead>Actions</TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <TableRow v-for="contact in props.contacts" :key="contact.id">
                        <TableCell>{{ contact.id }}</TableCell>
                        <TableCell>{{ contact.name }}</TableCell>
                        <TableCell>{{ contact.email }}</TableCell>
                        <TableCell>{{ contact.message }}</TableCell>
                        <TableCell>{{ contact.created_at }}</TableCell>
                        <TableCell>
                            <div class="flex items-center space-x-2">
                                <Link :href="`/admin/contacts/${contact.id}`" class="text-sm text-blue-600">View</Link>
                                <Link :href="`/admin/contacts/${contact.id}/edit`" class="text-sm text-green-600">Edit</Link>
                                <button @click="deleteContact(contact.id)" class="text-sm text-red-600">Delete</button>
                            </div>
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>

            
        </div>
    </AppLayout>



</template>