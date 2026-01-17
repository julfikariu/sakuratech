<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Textarea } from '@/components/ui/textarea';
import { store as storeComment } from '@/routes/admin/tasks/checklists/comments';
import axios from 'axios';
import { ref } from 'vue';

const props = defineProps<{
    taskId: number;
    checklistId: number;
}>();
const emit = defineEmits<{
    (e: 'created', payload: any): void
}>();

const body = ref('');
const errors = ref<any>({});
const processing = ref(false);

async function submit() {
    processing.value = true;
    try {
        const res = await axios.post(storeComment({ task: props.taskId, checklist: props.checklistId }).url, { body: body.value });
        const comment = res.data;
        body.value = '';
        errors.value = {};
        processing.value = false;
        emit('created', comment);
    } catch (err: any) {
        processing.value = false;
        if (err.response?.status === 422) {
            errors.value = err.response.data.errors || {};
        }
    }
}
</script>

<template>
    <div class="mt-4 bg-white dark:bg-gray-900 rounded shadow p-3">
        <h4 class="font-semibold mb-2">Add a comment</h4>
        <form @submit.prevent="submit">
            <div class="mb-2">
                <Textarea v-model="body" rows="3" />
                <div class="text-sm text-red-600 mt-1" v-if="errors.body">{{ errors.body }}</div>
            </div>
            <div class="flex gap-2">
                <Button type="submit" variant="save" :disabled="processing">Post Comment</Button>
            </div>
        </form>
    </div>
</template>