<script setup lang="ts">
import FlatpickerInput from '@/components/FlatpickerInput.vue';
import InputError from '@/components/InputError.vue';
import Modal from '@/components/Modal.vue';
import { Button } from '@/components/ui/button';
import Input from '@/components/ui/input/Input.vue';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Textarea } from '@/components/ui/textarea';
import { close, modal } from '@/composables/useModal';
import { store as taskStore, update as taskUpdate } from '@/routes/admin/tasks';
import { useForm } from '@inertiajs/vue3';
import { CalendarDays, LoaderCircle, Save, X } from 'lucide-vue-next';

interface Project { id: number; title: string; }
interface User { id: number; name: string; }
interface Task {
    id: number;
    project_id?: number | null;
    title: string;
    description?: string;
    status: string;
    priority?: string;
    due_date?: string;
    assigned_to?: number | null;
}

const props = defineProps<{
    projects: Project[];
    users: User[];
    task?: Task | null;
    is_edit: boolean;
}>();

const form = useForm({
    id: props.task?.id || 0,
    project_id: props.task?.project_id || null,
    title: props.task?.title || '',
    description: props.task?.description || '',
    status: props.task?.status || 'open',
    priority: props.task?.priority || 'medium',
    due_date: props.task?.due_date || '',
    assigned_to: props.task?.assigned_to || null,
});

function submitForm() {
    if (props.is_edit) {
        form.put(taskUpdate(form.id).url, {
            onSuccess: () => {
                form.reset();
                close();
                modal.value = null;
            }
        });
    } else {
        form.post(taskStore.url(), {           
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
    <Modal :show="true" :size="'lg'" title="Task" @close="close">
        <div class="pb-6">
            <form @submit.prevent="submitForm">
                <div class="grid gap-6">
                    <div class="flex items-center">
                        <Label class="w-1/8 justify-end mr-4">Project : </Label>
                        <div class="w-7/8">
                            <Select v-model="form.project_id" name="project_id" >
                                <SelectTrigger class="w-full">
                                    <SelectValue placeholder="Select project" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem v-for="p in props.projects" :key="p.id" :value="p.id">{{ p.title }}</SelectItem>
                                </SelectContent>
                            </Select>
                            <InputError :message="form.errors.project_id" />
                        </div>
                    </div>

                    <div class="flex items-center">
                        <Label class="w-1/8 justify-end mr-4">Title:</Label>
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
                        <Label class="w-1/8 justify-end mr-4">Assigned :</Label>
                        <div class="w-7/8">
                            <Select v-model="form.assigned_to" name="assigned_to" >
                                <SelectTrigger class="w-full">
                                    <SelectValue placeholder="Assign to" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem :value="null">Unassigned</SelectItem>
                                    <SelectItem v-for="u in props.users" :key="u.id" :value="u.id">{{ u.name }}</SelectItem>
                                </SelectContent>
                            </Select>
                            <InputError :message="form.errors.assigned_to" />
                        </div>
                    </div>

                    <div class="flex items-center">
                        <Label class="w-1/8 justify-end mr-4">Priority:</Label>
                        <div class="w-7/8">
                            <Select v-model="form.priority" name="priority" >
                                <SelectTrigger class="w-full">
                                    <SelectValue placeholder="Priority" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem value="low">Low</SelectItem>
                                    <SelectItem value="medium">Medium</SelectItem>
                                    <SelectItem value="high">High</SelectItem>
                                </SelectContent>
                            </Select>
                            <InputError :message="form.errors.priority" />
                        </div>
                    </div>

                    <div class="flex items-center">
                        <Label class="w-1/8 justify-end mr-4">Due :</Label>
                        <div class="w-7/8">
                            <div class="flex items-center border rounded">
                                <span class="p-2 h-9 bg-gray-100 text-sm text-gray-600">
                                    <CalendarDays class="w-4 h-4 inline-bloc" />
                                </span>
                                <FlatpickerInput id="due_date" v-model="form.due_date" placeholder="Due date" />
                            </div>
                            <InputError :message="form.errors.due_date" />
                        </div>
                    </div>

                    

                    <div class="flex items-center">
                        <Label class="w-1/8 justify-end mr-4"></Label>
                        <div class="flex gap-2 w-1/12">
                            <Button type="submit"  variant="save" :disabled="form.processing">
                                <LoaderCircle v-if="form.processing" class="w-4 h-4 animate-spin mr-2" />
                                <Save v-else class="w-4 h-4" /> Save
                            </Button>
                            <Button type="button" class="cursor-pointer" variant="secondary" @click.prevent="close">
                                <X class="w-4 h-4" />  Cancel
                            </Button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </Modal>
</template>
