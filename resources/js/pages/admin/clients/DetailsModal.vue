<script setup lang="ts">
import { Button } from '@/components/ui/button';
import {
    Table,
    TableBody,
    TableCell,
    TableRow,
} from '@/components/ui/table';
import { SquarePen, X } from 'lucide-vue-next';
import Modal from '@/components/Modal.vue';
import { close } from '@/composables/useModal';
import StatusBadge from '@/components/StatusBadge.vue';
import { router } from '@inertiajs/vue3';

interface Client {
    id: number;
    company_name: string;
    phone: string;
    address: string;
    website: string;
    status: string;
    created_at: string | null;
};


interface Props {
    client: Client;
}

const props = defineProps<Props>();

function goToEdit() {
    close();
    router.visit(`/admin/clients/${props.client.id}/edit`);
}

</script>

<template>
    <Modal :show="true" :size="'xl'" :title="'Leave Application Details'" @close="close">
        <div class="px-4">
            <div class="overflow-x-auto bg-white dark:bg-gray-900 rounded">
                <Table>
                    <TableBody>
                        <TableRow>
                            <TableCell class="font-semibold text-gray-700 w-1/8">Company Name</TableCell>
                            <TableCell class="text-center">:</TableCell>
                            <TableCell>{{ props.client.company_name }}</TableCell>
                        </TableRow>
                        <TableRow>
                            <TableCell class="font-semibold text-gray-700">Phone</TableCell>
                            <TableCell class="text-center">:</TableCell>
                            <TableCell>{{ props.client.phone }}</TableCell>
                        </TableRow>
                        <TableRow>
                            <TableCell class="font-semibold text-gray-700">Address</TableCell>
                            <TableCell class="text-center">:</TableCell>
                            <TableCell>{{ props.client.address }}</TableCell>
                        </TableRow>
                        <TableRow>
                            <TableCell class="font-semibold text-gray-700">Website</TableCell>
                            <TableCell class="text-center">:</TableCell>
                            <TableCell>{{ props.client.website }}</TableCell>
                        </TableRow>
                    
                        <TableRow>
                            <TableCell class="font-semibold text-gray-700">Status</TableCell>
                            <TableCell class="text-center">:</TableCell>
                            <TableCell>
                                <StatusBadge :status="props.client.status ?? 'Active'" />
                            </TableCell>
                        </TableRow>

                        <TableRow>
                            <TableCell class="font-semibold text-gray-700">Created At</TableCell>
                            <TableCell class="text-center">:</TableCell>
                            <TableCell>{{ props.client.created_at ?? '-' }}</TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>
        </div>

        <template #footer>
            <div class="flex justify-start gap-3">
                <Button @click="goToEdit" variant="edit" class="cursor-pointer">
                    <SquarePen class="w-4 h-4" /> Update
                </Button>

                <Button @click="close" variant="secondary" class="cursor-pointer">
                    <X class="w-4 h-4" /> Close
                </Button>
            </div>
        </template>
    </Modal>
</template>
