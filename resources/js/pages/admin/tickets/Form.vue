<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import Modal from '@/components/Modal.vue';
import RequiredSign from '@/components/RequiredSign.vue';
import { Button } from '@/components/ui/button';
import Input from '@/components/ui/input/Input.vue';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Textarea } from '@/components/ui/textarea';
import { close, modal } from '@/composables/useModal';
import { store as ticketStore, update as ticketUpdate } from '@/routes/admin/tickets';
import { useForm } from '@inertiajs/vue3';
import { LoaderCircle, Save, X } from 'lucide-vue-next';

interface User {
    id: number;
    name: string;
}

interface Ticket {
    id: number;
    title: string;
    description: string;
    assignee_id?: number | null;
    priority: 'Low' | 'Medium' | 'High';
    status: 'Open' | 'Pending' | 'Closed';
}

interface Props { 
    users: User[];
    ticket?: Ticket | null;
    is_edit: boolean;
}

const props = defineProps<Props>();

const form = useForm({
    id: props.ticket?.id || 0,
    title: props.ticket?.title || '',
    description: props.ticket?.description || '',
    assignee_id: props.ticket?.assignee_id || null,
    priority: props.ticket?.priority || 'Medium',
    status: props.ticket?.status || 'Open',
});

function submitForm() {
    if (props.is_edit) {
        form.put(ticketUpdate(form.id).url, {
            onSuccess: () => {
                form.reset();
                close();
                modal.value = null;
            }
        });
    } else {
        form.post(ticketStore.url(), {           
            onSuccess: () => {
                form.reset();
                close();
                modal.value = null; 
            }
        });
    }
}

</script>

<template>
 <Modal :show="true" :size="'lg'" title="Ticket" @close="close">
    <div class="pb-6">
            <form @submit.prevent="submitForm">
                <div class="grid gap-6">

                    <div class="flex items-center">
                        <Label class="w-1/8 justify-end mr-4"> <RequiredSign /> Title:</Label>
                        <div class="w-7/8">
                            <Input v-model="form.title" class="" rows="2" />
                            <InputError :message="form.errors.title" />
                        </div>
                    </div>

                    <div class="flex items-start">
                        <Label class="w-1/8 justify-end mr-4">Description :</Label>
                        <div class="w-7/8">
                            <Textarea v-model="form.description" rows="4"></Textarea>
                            <InputError :message="form.errors.description" />
                        </div>
                    </div>

                    <div class="flex items-center">
                        <Label class="w-1/8 justify-end mr-4">Assignee:</Label>
                        <div class="w-7/8">
                            <Select v-model="form.assignee_id" name="assignee_id" >
                                <SelectTrigger class="w-full">
                                    <SelectValue placeholder="Select assignee" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem :value="null">Unassigned</SelectItem>
                                    <SelectItem v-for="u in props.users" :key="u.id" :value="u.id">{{ u.name }}</SelectItem>
                                </SelectContent>
                            </Select>
                            <InputError :message="form.errors.assignee_id" />
                        </div>
                    </div>

                    <div class="flex items-center">
                        <Label class="w-1/8 justify-end mr-4">Priority :</Label>
                        <div class="w-7/8">
                            <Select v-model="form.priority" name="priority">
                                <SelectTrigger class="w-full">
                                    <SelectValue placeholder="Priority" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem value="Low">Low</SelectItem>
                                    <SelectItem value="Medium">Medium</SelectItem>
                                    <SelectItem value="High">High</SelectItem>
                                </SelectContent>
                            </Select>
                            <InputError :message="form.errors.priority" />
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <Label class="w-1/8 text-right justify-end">Status :</Label>
                        <div class="w-7/8">
                            <Select v-model="form.status" name="status">
                                <SelectTrigger class="w-full">
                                    <SelectValue placeholder="Status" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem value="Open">Open</SelectItem>
                                    <SelectItem value="Pending">Pending</SelectItem>
                                    <SelectItem value="Closed">Closed</SelectItem>
                                </SelectContent>
                            </Select>
                            <InputError :message="form.errors.status" />
                        </div>
                    </div>

                    <div class="flex items-center">
                        <Label class="w-1/8 justify-end mr-4"></Label>
                        <div class="flex gap-2 w-1/12">
                            <Button type="submit"  variant="save" :disabled="form.processing">
                                <LoaderCircle v-if="form.processing" class="w-4 h-4 animate-spin mr-2" />
                                <Save v-else class="w-4 h-4" /> Save
                            </Button>
                            <Button type="button" class="cursor-pointer" variant="secondary"
                                @click.prevent="close">
                                <X class="w-4 h-4" />  Cancel
                            </Button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
 </Modal>
</template>