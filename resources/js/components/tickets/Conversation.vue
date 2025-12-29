<script setup lang="ts">
import { deleteBySwal } from '@/composables/useSwal';
import { destroy as destroyReply } from '@/routes/admin/tickets/replies';

const props = defineProps<{
    replies: Array<{
        id: number;
        message: string;
        user: { id: number; name: string };
        created_at: string;
        can_delete?: boolean;
    }>;
    ticketId: number;
}>();

function confirmDelete(replyId: number) {
    deleteBySwal(destroyReply({ ticket: props.ticketId, reply: replyId }).url, 'reply');
}
</script>

<template>
    <div class="mt-6">
        <h3 class="text-lg font-medium mb-3">Conversation</h3>
        <div class="space-y-4">
            <div v-for="r in props.replies" :key="r.id" class="p-4 bg-white dark:bg-gray-900 rounded shadow">
                <div class="flex justify-between items-start">
                    <div>
                        <div class="font-semibold">{{ r.user.name }}</div>
                        <div class="text-sm text-gray-500">{{ r.created_at }}</div>
                    </div>
                    <div v-if="r.can_delete">
                        <button @click.prevent="confirmDelete(r.id)" class="text-sm text-red-600">Delete</button>
                    </div>
                </div>

                <div class="mt-2 text-sm text-gray-700 dark:text-gray-200">
                    <p v-html="r.message"></p>
                </div>
            </div>
        </div>
    </div>
</template>