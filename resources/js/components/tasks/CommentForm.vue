<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Textarea } from '@/components/ui/textarea';
import { show as taskShow } from '@/routes/admin/tasks';
import { store as storeComment } from '@/routes/admin/tasks/comments';
import { router, useForm } from '@inertiajs/vue3';

const props = defineProps<{
    taskId: number;
}>();

const form = useForm({ body: '' });

function submit() {
    form.post(storeComment({ task: props.taskId }).url, {
        preserveState: true,
        onSuccess: () => {
            form.reset();
            router.get(taskShow(props.taskId).url);
        }
    });
}
</script>

<template>
    <div class="mt-6 bg-white dark:bg-gray-900 rounded shadow p-4">
        <h3 class="font-semibold mb-2">Post a comment</h3>
        <form @submit.prevent="submit">
            <div class="mb-3">
                <Textarea v-model="form.body" rows="4" />
                <div class="text-sm text-red-600 mt-1" v-if="form.errors.body">{{ form.errors.body }}</div>
            </div>
            <div class="flex gap-2">
                <Button type="submit" variant="save" :disabled="form.processing">Post Comment</Button>
            </div>
        </form>
    </div>
</template>
