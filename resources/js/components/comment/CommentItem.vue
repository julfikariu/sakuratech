<script setup lang="ts">
import { ref } from 'vue';
import axios from 'axios';
import type { Comment } from '@/types/comment';

interface Props {
  comment: Comment;
}

const props = defineProps<Props>();
const emit = defineEmits<{
  updated: [comment: Comment];
  deleted: [id: number | string];
}>();

const isEditing = ref(false);
const editBody = ref(props.comment.body);
const isUpdating = ref(false);
const isDeleting = ref(false);

const startEdit = () => {
  editBody.value = props.comment.body;
  isEditing.value = true;
};

const cancelEdit = () => {
  isEditing.value = false;
  editBody.value = props.comment.body;
};

const saveEdit = async () => {
  if (!editBody.value.trim() || isUpdating.value) return;

  isUpdating.value = true;
  try {
    const { data } = await axios.put<Comment>(
      `/comments/${props.comment.id}`,
      { body: editBody.value }
    );
    emit('updated', data);
    isEditing.value = false;
  } catch (error) {
    console.error('Failed to update comment:', error);
  } finally {
    isUpdating.value = false;
  }
};

const deleteComment = async () => {
  if (isDeleting.value) return;

  isDeleting.value = true;
  try {
    await axios.delete(`/comments/${props.comment.id}`);
    emit('deleted', props.comment.id);
  } catch (error) {
    console.error('Failed to delete comment:', error);
  } finally {
    isDeleting.value = false;
  }
};
</script>

<template>
  <div
    class="rounded-lg border border-border bg-card p-3"
    :class="{ 'opacity-50': comment.is_optimistic }"
  >
    <!-- Header -->
    <div class="mb-2 flex items-center justify-between">
      <div class="flex items-center gap-2">
        <span class="text-sm font-medium">{{ comment.user.name }}</span>
        <span class="text-xs text-muted-foreground">{{ comment.created_at }}</span>
      </div>

      <!-- Actions -->
      <div v-if="!comment.is_optimistic && (comment.can_edit || comment.can_delete)" class="flex gap-1">
        <button
          v-if="comment.can_edit && !isEditing"
          @click="startEdit"
          class="text-xs text-muted-foreground hover:text-foreground"
        >
          Edit
        </button>
        <button
          v-if="comment.can_delete"
          @click="deleteComment"
          :disabled="isDeleting"
          class="text-xs text-destructive hover:text-destructive/80"
        >
          {{ isDeleting ? '...' : 'Delete' }}
        </button>
      </div>
    </div>

    <!-- Edit Mode -->
    <div v-if="isEditing" class="space-y-2">
      <textarea
        v-model="editBody"
        class="w-full rounded-md border border-input bg-background px-3 py-2 text-sm"
        rows="2"
      />
      <div class="flex gap-2">
        <button
          @click="saveEdit"
          :disabled="isUpdating"
          class="rounded-md bg-primary px-3 py-1 text-xs font-medium text-primary-foreground"
        >
          {{ isUpdating ? 'Saving...' : 'Save' }}
        </button>
        <button
          @click="cancelEdit"
          class="rounded-md border border-input px-3 py-1 text-xs"
        >
          Cancel
        </button>
      </div>
    </div>

    <!-- Display Mode -->
    <p v-else class="text-sm">{{ comment.body }}</p>
  </div>
</template>
