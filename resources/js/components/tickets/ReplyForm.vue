<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Textarea } from '@/components/ui/textarea';
import { show as ticketShow } from '@/routes/admin/tickets';
import { store as storeReply } from '@/routes/admin/tickets/replies';
import { router, useForm } from '@inertiajs/vue3';

const props = defineProps<{
    ticketId: number;
}>();

const form = useForm({
    message: '',
});

function submit() {
    form.post(storeReply(props.ticketId).url, {
        preserveState: true,
        onSuccess: () => {
            form.reset();
            // reload ticket details to get the new reply
            router.get(ticketShow(props.ticketId).url);
        }
    });
}
</script>

<template>
    <div class="mt-6 bg-white dark:bg-gray-900 rounded shadow p-4">
        <h3 class="font-semibold mb-2">Post a reply</h3>
        <form @submit.prevent="submit">
            <div class="mb-3">
                <Textarea v-model="form.message" rows="4" />
                <div class="text-sm text-red-600 mt-1" v-if="form.errors.message">{{ form.errors.message }}</div>
            </div>
            <div class="flex gap-2">
                <Button type="submit" variant="save" :disabled="form.processing">Post Reply</Button>
            </div>
        </form>
    </div>
</template>