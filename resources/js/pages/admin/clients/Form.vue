<script setup lang="ts">
import { useForm, Link } from '@inertiajs/vue3';
import { Label } from '@/components/ui/label';
import { Button } from '@/components/ui/button';
import Input from '@/components/ui/input/Input.vue';
import InputError from '@/components/InputError.vue';
import { LoaderCircle, MoveLeft, X, Save } from 'lucide-vue-next';
import AppLayout from '@/layouts/AppLayout.vue';
import { RadioGroup, RadioGroupItem } from '@/components/ui/radio-group';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import RequiredSign from '@/components/RequiredSign.vue';
import FlatpickerInput from '@/components/FlatpickerInput.vue';
import { type BreadcrumbItem } from '@/types';
import { dashboard } from "@/routes";
import PageHeader from '@/components/PageHeader.vue';
import { index as ClientsIndex } from "@/routes/admin/clients";
import { store as ClientStore } from '@/routes/admin/clients';
import password from '@/routes/password';

interface Client {
    id: number,
    name: number | null,
    email: string,
    company_name: string,
    phone: string,
    address: string,
    website: string,
    status: string,
}

interface Props {
    client?: Client | null;
    is_edit_mode?: boolean | null;
}

const props = defineProps<Props>();

const form = useForm({
    id: props.client?.id || null,
    company_name: props.client?.company_name || '',
    name: props.client?.name || null,
    email: props.client?.email || '',
    password: '',
    phone: props.client?.phone || '',
    address: props.client?.address || '',
    website: props.client?.website || '',
    status: props.client?.status || 'Active',
});

// Status options
const statusOptions = ['Active', 'Suspended'];

// Action
function submitForm() {
    if (props.is_edit_mode) {
        form.put(route('client.update', props.client?.id), {
            onSuccess: () => {
                form.reset();
            },
        });
    
    } else {
        form.post(ClientStore().url, {
            onSuccess: () => {
                form.reset();
            },
        });
    }
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    }, {
        title: 'Clients',
        href: ClientsIndex().url,
    }, {
        title: 'Add New',
        href: '',
    },
];
</script>

<template>
    <AppLayout>
        <div class="p-6">
            <PageHeader title="Clients" description="Create" :breadcrumbs="breadcrumbs">
                <Button variant="reset" @click="">
                    <MoveLeft /> Back
                </Button> 
            </PageHeader>


            <div class="mt-6">
                <form @submit.prevent="submitForm">
                    <div class="grid grid-cols-1 gap-6">
                        <div class="flex items-center">
                            <Label class="w-1/8 justify-end mr-4"><RequiredSign /> Company Name :</Label>
                            <div class="w-7/8">
                                <Input v-model="form.company_name" type="text" name="company_name" />
                                <InputError :message="form.errors.company_name" />                            
                            </div>
                        </div>

                        <div class="flex items-center">
                            <Label class="w-1/8 justify-end mr-4"><RequiredSign /> Full Name :</Label>
                            <div class="w-7/8">
                                <Input v-model="form.name" type="text" name="name" />
                                <InputError :message="form.errors.name" />                            
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="flex items-center">
                            <Label for="email" class="w-1/8 justify-end mr-4"><RequiredSign /> Email :</Label>
                            <div class="w-7/8">
                                <Input v-model="form.email" id="email" type="email" placeholder="example@email.com" />
                                <InputError :message="form.errors.email" />
                            </div>
                        </div>

                        <!-- Password -->
                        <div v-if="props.is_edit_mode === false" class="flex items-center">
                            <Label for="password" class="w-1/8 justify-end mr-4"> <RequiredSign /> Password :</Label>
                            <div class="w-7/8">
                                <Input v-model="form.password" id="password" type="password" placeholder="********" />
                                <InputError :message="form.errors.password" />
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="flex items-center">
                            <Label for="phone" class="w-1/8 justify-end mr-4">Phone :</Label>
                            <div class="w-7/8">
                                <Input v-model="form.phone" id="phone" type="text" placeholder="+1234567890" />
                                <InputError :message="form.errors.phone" />
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="flex items-center">
                            <Label for="address" class="w-1/8 justify-end mr-4">Address :</Label>
                            <div class="w-7/8">
                                <Input v-model="form.address" id="address" type="text" placeholder="123 Main St, City, Country" />
                                <InputError :message="form.errors.address" />
                            </div>
                        </div>
                        
                         <!-- Status -->
                        <div class="flex items-center">
                            <Label class="w-1/8 justify-end mr-4">Status :</Label>
                            <div class="w-7/8">
                                <RadioGroup v-model="form.status" defaultValue="Active" class="flex gap-6">
                                    <div class="flex items-center gap-2">
                                        <RadioGroupItem value="Active" id="male" />
                                        <Label for="male">Active</Label>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <RadioGroupItem value="Suspended" id="female" />
                                        <Label for="female">Suspended</Label>
                                    </div>
                                </RadioGroup>
                                <InputError :message="form.errors.status" />
                            </div>
                        </div>
                     
                    </div>
                    <div class="flex items-center mt-6">
                        <Label for="status" class="w-1/8 justify-end mr-4"></Label>
                        <div class="flex gap-2 w-1/12">
                            <Button type="submit"
                                variant="save"
                                :disabled="form.processing">
                                <LoaderCircle v-if="form.processing" class="w-4 h-4 animate-spin" />
                               <Save v-if="!form.processing" />  {{ props.is_edit_mode ? 'Update' : 'Create' }}
                            </Button>

                            <Link :href="ClientsIndex().url">
                                 <Button type="button" variant="destructive" class="gap-1">
                                  <X class="w-4 h-4"/>  Cancel
                                </Button>
                            </Link>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
