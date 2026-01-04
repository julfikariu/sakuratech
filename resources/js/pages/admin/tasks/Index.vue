<script setup lang="ts">
import ModalLink from '@/components/ModalLink.vue';
import NoResults from '@/components/NoResults.vue';
import PageHeader from '@/components/PageHeader.vue';
import Pagination from '@/components/Pagination.vue';
import { Button } from '@/components/ui/button';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import { deleteBySwal } from '@/composables/useSwal';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from "@/routes";
import { create as taskCreate, destroy as taskDelete, edit as taskEdit, show as taskShow } from '@/routes/admin/tasks';
import { type BreadcrumbItem } from '@/types';
import { Eye, Plus, SquarePen, Trash2 } from 'lucide-vue-next';

interface Flash {
    message?: string;
    type?: string;
}

const props = defineProps<{
    tasks: any | null;
    flash?: Flash;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Tasks',
        href: '',
    },
];

</script>

<template>
    <AppLayout>

        <div class="p-6">
            <PageHeader title="All Tasks" description="" :breadcrumbs="breadcrumbs">
            </PageHeader>

            <div class="flex justify-between items-center w-full mb-4">
                <ModalLink :href="taskCreate().url" :variant="'save'" title="Create New Task">
                    <Plus /> Add New
                </ModalLink>
            </div>

            <div v-if="props.tasks && props.tasks.data.length > 0"
                class="overflow-x-auto bg-white dark:bg-gray-900 rounded-lg shadow">
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead>Title</TableHead>
                            <TableHead>Project</TableHead>
                            <TableHead>Assigned To</TableHead>
                            <TableHead>Due Date</TableHead>
                            <TableHead>Status</TableHead>
                            <TableHead class="text-right">Actions</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="task in props.tasks.data" :key="task.id">
                            <TableCell>{{ task.title }}</TableCell>
                            <TableCell>{{ task.project_title }}</TableCell>
                            <TableCell>{{ task.assigned_to_name }}</TableCell>
                            <TableCell>{{ task.due_date }}</TableCell>
                            <TableCell>{{ task.status }}</TableCell>
                            <TableCell class="text-right flex gap-2 justify-end">
                                <a :href="taskShow({ task: task.id }).url">
                                    <Button variant="show" size="sm">
                                        <Eye class="w-4 h-4" />
                                    </Button>
                                </a>
                                <ModalLink :href="taskEdit({ task: task.id }).url" variant="edit" :size="'sm'">
                                    <SquarePen class="w-4 h-4" />
                                </ModalLink>
                                <Button @click="deleteBySwal(taskDelete({ task: task.id }).url, 'task')"
                                    variant="delete" size="sm" title="Delete task">
                                    <Trash2 class="w-4 h-4" />
                                </Button>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>

                <Pagination :from="Number(props.tasks.from)" :to="Number(props.tasks.to)"
                    :total="Number(props.tasks.total)" :links="props.tasks.links" class="mt-4" />

            </div>
            <NoResults v-else message="No tasks found" />           
        </div>
    </AppLayout>
</template>
