<script setup lang="ts">
import { ref, onMounted } from 'vue';
import axios from 'axios';
import type { Comment, CommentableType } from '@/types/comment';
import CommentItem from './CommentItem.vue';

interface Props {
  commentableType: CommentableType;
  commentableId: number;
}

const props = defineProps<Props>();

const comments = ref<Comment[]>([]);
const body = ref('');
const isLoading = ref(false);
const isSubmitting = ref(false);

const fetchComments = async () => {
  isLoading.value = true;
  try {
    const { data } = await axios.get<Comment[]>(
      `/comments/${props.commentableType}/${props.commentableId}`
    );
    comments.value = data;
  } catch (error) {
    console.error('Failed to load comments:', error);
  } finally {
    isLoading.value = false;
  }
};

const submitComment = async () => {
  if (!body.value.trim() || isSubmitting.value) return;

  const tempId = `temp-${Date.now()}`;
  const optimisticComment: Comment = {
    id: tempId,
    body: body.value,
    created_at: 'Just now',
    user: { id: 0, name: 'You' },
    can_edit: true,
    can_delete: true,
    is_optimistic: true,
  };

  const originalBody = body.value;
  comments.value.push(optimisticComment);
  body.value = '';
  isSubmitting.value = true;

  try {
    const { data } = await axios.post<Comment>('/comments', {
      commentable_type: props.commentableType,
      commentable_id: props.commentableId,
      body: originalBody,
    });

    const index = comments.value.findIndex((c) => c.id === tempId);
    if (index !== -1) {
      comments.value[index] = data;
    }
  } catch (error) {
    comments.value = comments.value.filter((c) => c.id !== tempId);
    body.value = originalBody;
    console.error('Failed to post comment:', error);
  } finally {
    isSubmitting.value = false;
  }
};

const handleUpdate = (updated: Comment) => {
  const index = comments.value.findIndex((c) => c.id === updated.id);
  if (index !== -1) {
    comments.value[index] = updated;
  }
};

const handleDelete = (id: number | string) => {
  comments.value = comments.value.filter((c) => c.id !== id);
};

onMounted(fetchComments);
</script>

<template>
  <div class="space-y-4">
    <h3 class="text-lg font-semibold">Comments</h3>

    <!-- Loading State -->
    <div v-if="isLoading" class="text-muted-foreground text-sm">
      Loading comments...
    </div>

    <!-- Comments List -->
    <div v-else-if="comments.length" class="space-y-3">
      <CommentItem
        v-for="comment in comments"
        :key="comment.id"
        :comment="comment"
        @updated="handleUpdate"
        @deleted="handleDelete"
      />
    </div>

    <!-- Empty State -->
    <p v-else class="text-muted-foreground text-sm">No comments yet.</p>

    <!-- Comment Form -->
    <form @submit.prevent="submitComment" class="flex gap-2">
      <input
        v-model="body"
        type="text"
        placeholder="Write a comment..."
        class="flex-1 rounded-md border border-input bg-background px-3 py-2 text-sm"
        :disabled="isSubmitting"
      />
      <button
        type="submit"
        :disabled="!body.trim() || isSubmitting"
        class="rounded-md bg-primary px-4 py-2 text-sm font-medium text-primary-foreground disabled:opacity-50"
      >
        {{ isSubmitting ? 'Posting...' : 'Post' }}
      </button>
    </form>
  </div>
</template>
