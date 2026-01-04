<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Textarea } from '@/components/ui/textarea';
import { deleteBySwal } from '@/composables/useSwal';
import { show as taskShow } from '@/routes/admin/tasks';
import { destroy as destroyComment, update as updateComment } from '@/routes/admin/tasks/comments';
import { router, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps<{
    comments: Array<{
        id: number;
        body: string;
        user: { id: number; name: string };
        created_at: string;
        can_edit?: boolean;
        can_delete?: boolean;
    }>;
    taskId: number;
}>();

const editingId = ref<number | null>(null);
const editForm = useForm({ body: '' });

function confirmDelete(commentId: number) {
    deleteBySwal(destroyComment({ task: props.taskId, comment: commentId }).url, 'comment');
}

function startEdit(comment: any) {
    editingId.value = comment.id;
    editForm.body = comment.body;
}

function cancelEdit() {
    editingId.value = null;
    editForm.reset();
}

function submitEdit(commentId: number) {
    editForm.put(updateComment({ task: props.taskId, comment: commentId }).url, {
        preserveState: true,
        onSuccess: () => {
            editingId.value = null;
            editForm.reset();
            router.get(taskShow(props.taskId).url);
        }
    });
}
</script>

<template>
    <div class="mt-6">
        <h3 class="text-lg font-medium mb-3">Comments</h3>
        <div class="space-y-4">
            <div v-for="c in props.comments" :key="c.id" class="p-4 bg-white dark:bg-gray-900 rounded shadow">
                <div class="flex justify-between items-start">
                    <div>
                        <div class="font-semibold">{{ c.user.name }}</div>
                        <div class="text-sm text-gray-500">{{ c.created_at }}</div>
                    </div>

                    <div v-if="c.can_edit || c.can_delete" class="flex items-center gap-2">
                        <template v-if="c.can_edit">
                            <button v-if="editingId !== c.id" @click.prevent="startEdit(c)" class="text-sm text-muted-foreground">Edit</button>
                        </template>
                        <button v-if="c.can_delete" @click.prevent="confirmDelete(c.id)" class="text-sm text-red-600">Delete</button>
                    </div>
                </div>

                <div class="mt-2 text-sm text-gray-700 dark:text-gray-200">
                    <div v-if="editingId === c.id">
                        <Textarea v-model="editForm.body" rows="3" />
                        <div class="flex gap-2 mt-2">
                            <Button variant="save" :disabled="editForm.processing" @click.prevent="submitEdit(c.id)">Save</Button>
                            <Button variant="secondary" @click.prevent="cancelEdit">Cancel</Button>
                        </div>
                        <div class="text-sm text-red-600 mt-1" v-if="editForm.errors.body">{{ editForm.errors.body }}</div>
                    </div>
                    <div v-else>
                        <p v-html="c.body"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
