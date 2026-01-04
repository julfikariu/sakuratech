<script setup lang="ts">
import ModalLink from '@/components/ModalLink.vue';
import NoResults from '@/components/NoResults.vue';
import PageHeader from '@/components/PageHeader.vue';
import { deleteBySwal } from '@/composables/useSwal';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { create as checklistCreate, destroy as checklistDestroy, edit as checklistEdit } from '@/routes/admin/tasks/checklists';
import { type BreadcrumbItem } from '@/types';
import { SquarePen, Trash } from 'lucide-vue-next';
import TabMenu from './TabMenu.vue';

const props = defineProps<{
    task: any;
    checklists: any[];
}>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: dashboard().url },
    { title: 'Tasks', href: '/admin/tasks' },
    { title: props.task.title, href: `/admin/tasks/${props.task.id}` },
    { title: 'Checklists', href: '' },
];
</script>

<template>
    <AppLayout>
        <div class="p-6">
            <TabMenu :task_id="props.task.id" />
            <PageHeader title="Checklists" description="" :breadcrumbs="breadcrumbs" />

            <div class="flex justify-between items-center w-full mb-4">
                <ModalLink :href="checklistCreate({ task: props.task.id }).url" :variant="'save'" title="Add Checklist">
                    Add
                </ModalLink>
            </div>

            <div v-if="props.checklists && props.checklists.length > 0" class="rounded-lg border bg-card p-4">
                <ul>
                    <li v-for="c in props.checklists" :key="c.id" class="flex items-center justify-between py-2 border-b">
                        <div>
                            <div class="font-semibold">{{ c.title }}</div>
                            <div class="text-xs text-muted-foreground">{{ c.created_at }}</div>
                        </div>
                        <div class="flex items-center gap-2">
                            <ModalLink :href="checklistEdit({ task: props.task.id, checklist: c.id }).url" title="Edit Checklist">
                                <SquarePen class="w-4 h-4 text-muted-foreground" />
                            </ModalLink>
                            <button @click="deleteBySwal(checklistDestroy({ task: props.task.id, checklist: c.id }).url, 'checklist')" class="text-red-600">
                                <Trash class="w-4 h-4" />
                            </button>
                        </div>
                    </li>
                </ul>
            </div>

            <NoResults v-else message="No checklist items found" />

        </div>
    </AppLayout>
</template>