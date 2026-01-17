<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Textarea } from '@/components/ui/textarea';
import { destroy as destroyComment, update as updateComment } from '@/routes/admin/tasks/checklists/comments';
import axios from 'axios';
import Swal from 'sweetalert2';
import { ref, watch } from 'vue';

const props = defineProps<{
    comments: Array<any>;
    taskId: number;
    checklistId: number;
}>();

const list = ref<Array<any>>(props.comments ? [...props.comments] : []);
watch(() => props.comments, (val) => {
    list.value = val ? [...val] : [];
});

const editingId = ref<number | null>(null);
const editForm = ref<{ body: string; errors: { [key: string]: any }; processing: boolean }>({ body: '', errors: {}, processing: false });

function confirmDelete(commentId: number) {
    Swal.fire({
        title: 'Are you sure?',
        text: "This action cannot be undone!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
    }).then(async (result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Deleting...',
                text: 'Please wait while we delete.',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => Swal.showLoading(),
            });

            try {
                await axios.delete(destroyComment({ task: props.taskId, checklist: props.checklistId, comment: commentId }).url);
                list.value = list.value.filter((c) => c.id !== commentId);
                Swal.close();
                Swal.fire('Deleted!', `The comment has been deleted.`, 'success');
            } catch (err) {
                Swal.close();
                Swal.fire('Error!', 'Something went wrong.', 'error');
            }
        }
    });
}

function startEdit(comment: any) {
    editingId.value = comment.id;
    editForm.value.body = comment.body;
    editForm.value.errors = {};
}

function cancelEdit() {
    editingId.value = null;
    editForm.value = { body: '', errors: {}, processing: false };
}

async function submitEdit(commentId: number) {
    editForm.value.processing = true;
    try {
        const res = await axios.put(updateComment({ task: props.taskId, checklist: props.checklistId, comment: commentId }).url, { body: editForm.value.body });
        const updated = res.data;
        const idx = list.value.findIndex((c) => c.id === commentId);
        if (idx !== -1) list.value[idx] = updated;
        editingId.value = null;
        editForm.value = { body: '', errors: {}, processing: false };
    } catch (err: any) {
        if (err.response?.status === 422) {
            editForm.value.errors = err.response.data.errors || {};
        }
        editForm.value.processing = false;
    }
}
</script>

<template>
    <div class="mt-4">
        <div class="space-y-4">
            <div v-for="c in list" :key="c.id" class="p-3 bg-white dark:bg-gray-900 rounded shadow">
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
