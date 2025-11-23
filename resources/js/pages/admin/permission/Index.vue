<script setup lang="ts">
import Modal from '@/components/Modal.vue';
import NoResults from '@/components/NoResults.vue';
import PageHeader from '@/components/PageHeader.vue';
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
import { dashboard } from '@/routes';
import { destroy as permissionDelete } from '@/routes/admin/permission';
import { type BreadcrumbItem } from '@/types';
import { Plus, SquarePen, Trash2Icon } from 'lucide-vue-next';
import { ref } from 'vue';
import PermissionForm from './Form.vue';

interface Permission {
    id: number;
    name: string;
}

interface Props {
    permissions: Permission[];
}

const props = defineProps<Props>();

const isModalOpen = ref(false);
const modalMode = ref<'create' | 'edit'>('create');
const editingPermission = ref<Permission | null>(null);

function addPermission() {
    modalMode.value = 'create';
    isModalOpen.value = true;
    editingPermission.value = null;
}

function closeModal() {
    isModalOpen.value = false;
}

function editPermission(permission: Permission) {
    modalMode.value = 'edit';
    editingPermission.value = permission;
    isModalOpen.value = true;
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Permissions',
        href: '',
    },
];
</script>

<template>
    <AppLayout>
        <div class="p-6">

            <!-- Modal with transition -->
            <Transition enter-active-class="transition duration-300 ease-out"
                enter-from-class="transform scale-95 opacity-0" enter-to-class="transform scale-100 opacity-100"
                leave-active-class="transition duration-200 ease-in" leave-from-class="transform scale-100 opacity-100"
                leave-to-class="transform scale-95 opacity-0">
                <Modal v-if="isModalOpen" :show="isModalOpen"
                    :title="modalMode === 'create' ? 'Add Permission' : 'Edit Permission'" @close="closeModal">
                    <PermissionForm :mode="modalMode" :permission="editingPermission" @closemodal="closeModal" />
                </Modal>
            </Transition>

            <PageHeader title="All Permissions" description="" :breadcrumbs="breadcrumbs">
                <Button variant="save" @click="addPermission">
                    <Plus class="w-4 h-4" /> Add New
                </Button>
            </PageHeader>

            <div v-if="props.permissions && props.permissions.length > 0" class="mt-6 overflow-x-auto">
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead>ID</TableHead>
                            <TableHead>Name</TableHead>
                            <TableHead class="text-right">Actions</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="permission in props.permissions" :key="permission.id">
                            <TableCell>{{ permission.id }}</TableCell>
                            <TableCell>{{ permission.name }}</TableCell>
                            <TableCell class="text-right flex gap-2 justify-end">
                                <Button @click="editPermission(permission)" class="p-2" variant="edit" size="sm"
                                    aria-label="Edit permission">
                                    <SquarePen class="w-4 h-4" />
                                </Button>

                                <Button @click="deleteBySwal(permissionDelete({ id: permission.id }).url, 'permission')"
                                    variant="delete" size="sm" title="Delete permission">
                                    <Trash2Icon class="w-4 h-4" />
                                </Button>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>
            <NoResults v-else />
        </div>
    </AppLayout>
</template>
