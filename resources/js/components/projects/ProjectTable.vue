<script setup lang="ts">
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table'
import { Button } from '@/components/ui/button';
import { Eye, SquarePen, Trash2Icon } from 'lucide-vue-next';
import { Link } from '@inertiajs/vue3';
import NoResults from '@/components/NoResults.vue';
import Pagination from '@/components/Pagination.vue';
import { show as projectShow } from '@/routes/admin/projects';
import { edit as projectEdit } from '@/routes/admin/projects';
import { destroy as projectDelete } from '@/routes/admin/projects';
import ModalLink from '@/components/ModalLink.vue';
import StatusBadge from '@/components/StatusBadge.vue';
import { deleteBySwal } from '@/composables/useSwal';
import type { PaginatedProjects } from '@/types/project';

const props = withDefaults(
    defineProps<{
        projects: PaginatedProjects | null;
        showClientColumn?: boolean;
    }>(), {
    showClientColumn: true,
});

</script>

<template>
    <div v-if="props.projects && props.projects.data.length > 0"
        class="overflow-x-auto bg-white dark:bg-gray-900 rounded shadow">
        <Table>
            <TableHeader>
                <TableRow>                    
                    <TableHead>Title</TableHead>
                    <TableHead v-if="props.showClientColumn">Client</TableHead>
                    <TableHead>Start Date</TableHead>
                    <TableHead>Deadline</TableHead>
                    <TableHead>Status</TableHead>
                    <TableHead class="text-right">Actions</TableHead>
                </TableRow>
            </TableHeader>
            <TableBody>
                <TableRow v-for="item in props.projects.data" :key="item.id">                
                    <TableCell>{{ item.title }}</TableCell>
                    <TableCell v-if="props.showClientColumn">{{ item.client_name }}</TableCell>
                    <TableCell>{{ item.start_date }}</TableCell>
                    <TableCell>{{ item.deadline }}</TableCell>
                    <TableCell><StatusBadge :status="item.status" /></TableCell>
                    <TableCell class="text-right flex gap-2 justify-end">                    
                        <Link :href="projectShow(item.id).url">
                            <Button variant="show" size="sm">
                                <Eye class="w-4 h-4" />
                            </Button>
                        </Link>
                        <ModalLink :href="projectEdit(item.id).url" variant="edit" :size="'sm'">
                            <SquarePen class="w-4 h-4" />
                        </ModalLink>
                        <Button @click="deleteBySwal(projectDelete({ project: item.id }).url, 'project')"
                            variant="delete" size="sm" title="Delete project">
                            <Trash2Icon class="w-4 h-4" />
                        </Button>
                    </TableCell>
                </TableRow>
            </TableBody>
        </Table>
        <Pagination :from="Number(props.projects.from)" :to="Number(props.projects.to)"
            :total="Number(props.projects.total)" :links="props.projects.links" class="mt-4" />
    </div>
    <NoResults v-else />
</template>