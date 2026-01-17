<script setup lang="ts">
import PageHeader from '@/components/PageHeader.vue';
import CommentForm from '@/components/tasks/CommentForm.vue';
import Comments from '@/components/tasks/Comments.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from "@/routes";
import TabMenu from './TabMenu.vue';
import { router } from '@inertiajs/vue3';
import CommentSection from '@/components/comment/CommentSection.vue';


interface Task {
    id: number;
    title: string;
    description?: string;
    project_title?: string;
    assigned_to_name?: string;
    due_date?: string;
    status?: string;
    priority?: string;
}

import { ref } from 'vue';

const props = defineProps<{ task: Task, comments: any[] }>();

// const comments = ref(props.comments || []);

function onCommentCreated() {
    router.reload({
        only: ['comments'],
    });
}

const breadcrumbs = [
    { title: 'Dashboard', href: dashboard().url },
    { title: 'Tasks', href: '/admin/tasks' },
    { title: props.task.title, href: '' },
];
</script>

<template>
    <AppLayout>
        <div class="p-6">
            <TabMenu :task_id="props.task.id" />
            <PageHeader :title="props.task.title" description="" :breadcrumbs="breadcrumbs" />

            <div class="rounded-lg border bg-card p-6">
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <h3 class="font-semibold">Project</h3>
                        <p class="text-sm text-muted-foreground">{{ props.task.project_title }}</p>

                        <h3 class="font-semibold mt-4">Assigned To</h3>
                        <p class="text-sm text-muted-foreground">{{ props.task.assigned_to_name || 'Unassigned' }}</p>

                    </div>
                    <div>
                        <h3 class="font-semibold">Due Date</h3>
                        <p class="text-sm text-muted-foreground">{{ props.task.due_date || '-' }}</p>

                        <h3 class="font-semibold mt-4">Status / Priority</h3>
                        <p class="text-sm text-muted-foreground">{{ props.task.status }} / {{ props.task.priority }}</p>
                    </div>
                </div>

                <div class="mt-6">
                    <h3 class="font-semibold">Description</h3>
                    <p class="text-sm text-muted-foreground" v-if="props.task.description">{{ props.task.description }}</p>
                    <p class="text-sm text-muted-foreground" v-else>No description provided.</p>
                </div>

                <!-- <Comments :comments="comments" :taskId="props.task.id" />
                <CommentForm :taskId="props.task.id" @created="onCommentCreated" /> -->

                <CommentSection commentable-type="task" :commentable-id="task.id" />


            </div>
        </div>
    </AppLayout>
</template>
