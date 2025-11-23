<script setup lang="ts">
import Modal from '@/components/Modal.vue';
import { Button } from '@/components/ui/button';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import AppLayout from '@/layouts/AppLayout.vue';
import { deleteBySwal } from '@/composables/useSwal';
import { KeyIcon, SquarePen, Trash2Icon, Plus } from 'lucide-vue-next';
// import RolePermissionModal from '@Modules/DevTool/resources/js/pages/rolepermission/RolePermissionModal.vue';
import { ref } from 'vue';
import { type BreadcrumbItem } from '@/types';
import PageHeader from '@/components/PageHeader.vue';
import { dashboard } from '@/routes';
import type { Role } from '@/types/models';
import NoResults from '@/components/NoResults.vue';
import RoleForm from './Form.vue';
import {  destroy as roleDelete } from '@/routes/admin/role';


interface Props {
    roles: Role[];
}

const props = defineProps<Props>();

const isModalOpen = ref(false);
const modalMode = ref<'create' | 'edit'>('create');
const editingRole = ref<Role | null>(null);
const isPermModalOpen = ref(false);
const permRoleId = ref<number | null>(null);

function addRole() {
    modalMode.value = 'create';
    isModalOpen.value = true;
    editingRole.value = null;
}

// Close modal
function closeModal() {
    isModalOpen.value = false;
}

function editRole(role: Role) {
    modalMode.value = 'edit';
    editingRole.value = role;
    isModalOpen.value = true;
}

function openPermissionModal(role: Role) {
    permRoleId.value = role.id;
    isPermModalOpen.value = true;
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Roles',
        href: '',
    },
];

</script>

<template>
    <AppLayout>
        <div class="p-6">

            <!-- Modal -->
            <Modal :show="isModalOpen" :title="modalMode === 'create' ? 'Add Role' : 'Edit Role'" @close="closeModal">
                <RoleForm :mode="modalMode" :role="editingRole" @closemodal="closeModal" />
            </Modal>

            <PageHeader title="All Roles" description="" :breadcrumbs="breadcrumbs">
                <Button variant="save" @click="addRole">
                    <Plus class="w-4 h-4" /> Add New
                </Button>
            </PageHeader>

            <div v-if="props.roles && props.roles.length > 0" class="mt-6 overflow-x-auto">
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead>ID</TableHead>
                            <TableHead>Name</TableHead>
                            <TableHead>Description</TableHead>
                            <TableHead class="text-right">Actions</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="role in props.roles" :key="role.id">
                            <TableCell>{{ role.id }}</TableCell>
                            <TableCell>{{ role.name }}</TableCell>
                            <TableCell>{{ role.description }}</TableCell>
                            <TableCell class="text-right flex gap-2 justify-end">
                                <!-- <Button @click="openPermissionModal(role)" variant="assign" size="sm"
                                aria-label="Edit Role Permissions">
                                <KeyIcon class="w-4 h-4" />
                            </Button> -->

                                <Button @click="editRole(role)" class="p-2" variant="edit" size="sm"
                                    aria-label="Edit role">
                                    <SquarePen class="w-4 h-4" />
                                </Button>

                                <Button @click="deleteBySwal(roleDelete({ id: role.id }).url, 'role')" variant="delete"
                                    size="sm" title="Delete role">
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

    <!-- Role Permission Modal -->
    <!-- <RolePermissionModal :open="isPermModalOpen" :role-id="permRoleId" @close="isPermModalOpen = false"
        @saved="() => {}" /> -->
</template>
