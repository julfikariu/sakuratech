<script setup lang="ts">
import PageHeader from '@/components/PageHeader.vue';
import Conversation from '@/components/tickets/Conversation.vue';
import ReplyForm from '@/components/tickets/ReplyForm.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from "@/routes";
import { index as ticketIndex } from '@/routes/admin/tickets';

import { type BreadcrumbItem } from '@/types';

const props = defineProps<{
    ticket: any;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Tickets',
        href: ticketIndex().url,
    },
    {
        title: props.ticket.title,
        href: '',
    },
];

</script>

<template>
<AppLayout>
    <div class="p-6">
        <PageHeader :title="`Ticket - ${props.ticket.title}`" description="" :breadcrumbs="breadcrumbs">
        </PageHeader>

        <div class="mt-6 bg-white dark:bg-gray-900 rounded shadow">
            <div class="p-6">
                <h2 class="text-2xl font-semibold mb-4">Ticket Information</h2>
                <p><strong>Title:</strong> {{ props.ticket.title }}</p>
                <p><strong>Description:</strong> {{ props.ticket.description }}</p>
                <p><strong>Priority:</strong> {{ props.ticket.priority }}</p>
                <p><strong>Status:</strong> {{ props.ticket.status }}</p>
                <p><strong>Assignee:</strong> {{ props.ticket.assignee?.name || 'Unassigned' }}</p>
            </div>
        </div>

        <Conversation :replies="props.ticket.replies || []" :ticketId="props.ticket.id" />
        <ReplyForm :ticketId="props.ticket.id" />
    </div>
</AppLayout>
</template>