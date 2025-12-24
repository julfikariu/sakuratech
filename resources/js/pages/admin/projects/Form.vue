<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import Input from '@/components/ui/input/Input.vue';
import { Textarea } from '@/components/ui/textarea';
import { useForm } from '@inertiajs/vue3';
import {  Bell, LoaderCircle, Mail, Save, X, Star, CalendarDays } from 'lucide-vue-next';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import Modal from '@/components/Modal.vue';
import { modal, close } from  '@/composables/useModal';
import FlatpickerInput from '@/components/FlatpickerInput.vue';
import { store as projectStore } from '@/routes/admin/projects';
import { update as projectUpdate } from '@/routes/admin/projects';
import { computed, ref, watch, onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3';
import RequiredSign from '@/components/RequiredSign.vue';
import { RadioGroup, RadioGroupItem } from '@/components/ui/radio-group';

interface Client {
    id: number;
    company_name: string;
}

interface Project {
    id: number;
    client_id: number;
    title: string;
    description: string;
    start_date: string;
    deadline: string;
    progress: number;
    status: string;
}

interface Props { 
    clients: Client[]; 
    project?: Project | null;
    is_edit: boolean;
}

const props = defineProps<Props>();

const files = ref<File[]>([]);

const form = useForm({
    id: props.project?.id || 0,
    client_id: props.project?.client_id || null,
    title: props.project?.title || '',
    description: props.project?.description || '',
    start_date: props.project?.start_date || '',
    deadline: props.project?.deadline || '',
    progress_info: props.project?.progress || 0,
    status: props.project?.status || 'Pending',
});



function submitForm() {
    if (props.is_edit) {
        form.put(projectUpdate(form.id).url, {
            onSuccess: () => {
                form.reset();
                files.value = [];
                close();
                modal.value=null;
            },
            onError: (e) => {
                console.log('Error occurred', e);
            }
        });
    } else {

        form.post(projectStore.url(), {           
            onSuccess: () => {
                form.reset();
                files.value = [];
                close();
                modal.value=null; 
            }
        });
    }
}

</script>

<template>
 <Modal :show="true" :size="'lg'" title="Project Create" @close="close">
    <div class="pb-6">
            <form @submit.prevent="submitForm">
                <div class="grid gap-6">
            
                    <div class="flex items-center">
                        <Label class="w-1/8 justify-end mr-4">Client : </Label>
                        <div class="w-7/8">
                            <Select v-model="form.client_id" name="client_id" >
                                <SelectTrigger class="w-full">
                                    <SelectValue placeholder="Select client" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem v-for="u in props.clients" :key="u.id" :value="u.id">{{ u.company_name }}</SelectItem>
                                </SelectContent>
                            </Select>
                            <InputError :message="form.errors.client_id" />
                        </div>
                    </div>

                    <div class="flex items-center">
                        <Label class="w-1/8 justify-end mr-4"> <RequiredSign /> Title:</Label>
                        <div class="w-7/8">
                            <Input v-model="form.title" class="" rows="2" />
                            <InputError :message="form.errors.title" />
                        </div>
                    </div>

                    <div class="flex items-center">
                        <Label class="w-1/8 justify-end mr-4"><RequiredSign /> Date :</Label>
                        <div class="w-7/8">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="flex items-center border  h-9 rounded">
                                    <span class="p-2 h-9 bg-gray-100 text-sm text-gray-600">
                                        <CalendarDays class="w-4 h-4 mr-1 inline-bloc" />
                                    </span>
                                    <FlatpickerInput 
                                        id="start_date"
                                        v-model="form.start_date"                                     
                                        placeholder="Select start date..." 
                                    />
                                </div>

                                <div class="flex items-center border rounded">
                                    <span class="p-2 h-9 bg-gray-100  text-sm text-gray-600">
                                        <CalendarDays class="w-4 h-4 inline-bloc" />
                                    </span>
                                    <FlatpickerInput 
                                        id="deadline"
                                        v-model="form.deadline"
                                        placeholder="Select deadline"
                                    />
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <InputError :message="form.errors.start_date" /> 
                                <InputError :message="form.errors.deadline" /> 
                            </div>
                        </div>
                    </div>

                    
                    <div class="flex items-start">
                        <Label class="w-1/8 justify-end mr-4">Description :</Label>
                        <div class="w-7/8">
                            <Textarea v-model="form.description" rows="4"></Textarea>
                            <InputError :message="form.errors.description" />
                        </div>
                    </div>
                    <div class="flex items-start">
                        <Label class="w-1/8 justify-end mr-4">Progress :</Label>
                        <div class="w-7/8">
                            <Input v-model="form.progress_info" type="number" min="0" max="100" />
                            <InputError :message="form.errors.progress" />
                        </div>
                    </div>  

                     <!-- Status -->
                    <div class="flex items-center gap-3">
                        <Label class="w-1/8 text-right justify-end">Status :</Label>
                        <div class="w-7/8">
                            <RadioGroup v-model="form.status" defaultValue="Pending" class="flex gap-6">
                                <div class="flex items-center gap-2">
                                    <RadioGroupItem value="Pending" id="inactive" />
                                    <Label for="inactive">Pending</Label>
                                </div>
                                <div class="flex items-center gap-2">
                                    <RadioGroupItem value="Active" id="active" />
                                    <Label for="active">Active</Label>
                                </div>
                               
                                 <div class="flex items-center gap-2">
                                    <RadioGroupItem value="Completed" id="inactive" />
                                    <Label for="inactive">Completed</Label>
                                </div>
                            </RadioGroup>
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
