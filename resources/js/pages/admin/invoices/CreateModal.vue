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
import { store as invoiceStore } from '@/routes/admin/invoices';
import { update as invoiceUpdate } from '@/routes/admin/invoices';
// import { getProjectsByClient as getProjectsByClient } from '@/routes/admin/get-projects-by-client';
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
    title: string;
}

interface Invoice {
    id: number;
    client_id: number;
    project_id: number;
    issue_date: string;
    due_date: string;
    status: string;
    notes: string;
}

interface Props { 
    clients: Client[]; 
    invoice?: Invoice | null;
}

const projects = ref<Project[]>([]);

const props = defineProps<Props>();

const form = useForm({
    id: props.invoice?.id || 0,
    client_id: props.invoice?.client_id || null,
    project_id: props.invoice?.project_id || null,
    issue_date: props.invoice?.issue_date || '',
    due_date: props.invoice?.due_date || '',
    notes: props.invoice?.notes || '',
    status: props.invoice?.status || 'draft',
});

watch(() => form.client_id, (newClientId) => {
    if (newClientId) {
        fetch(`/admin/get-projects-by-client/${newClientId}`)
            .then(response => response.json())
            .then(data => {
                projects.value = data;
            });
    } else {
        projects.value = [];
    }
});


function submitForm() {
 
    form.post(invoiceStore.url(), {           
        onSuccess: () => {
            form.reset();
            close();
            modal.value=null; 
        }
    });    
}

</script>

<template>
 <Modal :show="true" :size="'lg'" title="Invoice Create" @close="close">
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
                        <Label class="w-1/8 justify-end mr-4">Project : </Label>
                        <div class="w-7/8">
                            <Select v-model="form.project_id" name="project_id" >
                                <SelectTrigger class="w-full">
                                    <SelectValue placeholder="Select project" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem v-for="p in projects" :key="p.id" :value="p.id">{{ p.title }}</SelectItem>
                                </SelectContent>
                            </Select>
                            <InputError :message="form.errors.project_id" />
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
                                        id="issue_date"
                                        v-model="form.issue_date"                                     
                                        placeholder="Select start date..." 
                                    />
                                </div>

                                <div class="flex items-center border rounded">
                                    <span class="p-2 h-9 bg-gray-100  text-sm text-gray-600">
                                        <CalendarDays class="w-4 h-4 inline-bloc" />
                                    </span>
                                    <FlatpickerInput 
                                        id="due_date"
                                        v-model="form.due_date"
                                        placeholder="Select due date"
                                    />
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <InputError :message="form.errors.issue_date" /> 
                                <InputError :message="form.errors.due_date" /> 
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <Label class="w-1/8 justify-end mr-4">Notes :</Label>
                        <div class="w-7/8">
                            <Textarea v-model="form.notes" rows="4"></Textarea>
                            <InputError :message="form.errors.notes" />
                        </div>
                    </div>
                   

                     <!-- Status -->
                    <div class="flex items-center gap-3">
                        <Label class="w-1/8 text-right justify-end">Status :</Label>
                        <div class="w-7/8">
                            <RadioGroup v-model="form.status" defaultValue="draft" class="flex gap-6">
                                <div class="flex items-center gap-2">
                                    <RadioGroupItem value="draft" id="inactive" />
                                    <Label for="inactive">Draft</Label>
                                </div>
                                <div class="flex items-center gap-2">
                                    <RadioGroupItem value="paid" id="paid" />
                                    <Label for="paid">Paid</Label>
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
                                <Save v-else class="w-4 h-4" /> Create
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
