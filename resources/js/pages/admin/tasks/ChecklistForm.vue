<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import Modal from '@/components/Modal.vue';
import { Button } from '@/components/ui/button';
import Input from '@/components/ui/input/Input.vue';
import { Label } from '@/components/ui/label';
import { close, modal } from '@/composables/useModal';
import { useForm } from '@inertiajs/vue3';
import { LoaderCircle, Save, X } from 'lucide-vue-next';

const props = defineProps<{ task: any; is_edit: boolean; checklist?: any }>();

const form = useForm({ title: '' });

// prefill when editing
if (props.is_edit && props.checklist) {
    form.title = props.checklist.title ?? '';
}

import { store as checklistStore, update as checklistUpdate } from '@/routes/admin/tasks/checklists';

function submitForm() {
    if (props.is_edit && props.checklist) {
        form.put(checklistUpdate({ task: props.task.id, checklist: props.checklist.id }).url, {
            onSuccess: () => {
                form.reset();
                close();
                modal.value = null;
            }
        });
        return;
    }

    form.post(checklistStore({ task: props.task.id }).url, {
        onSuccess: () => {
            form.reset();
            close();
            modal.value = null;
        }
    });
}
</script>

<template>
    <Modal :show="true" :size="'sm'" title="Add Checklist" @close="close">
        <div class="pb-6">
            <form @submit.prevent="submitForm">
                <div class="grid gap-6">
                    <div class="flex items-center">
                        <Label class="w-1/8 justify-end mr-4">Title:</Label>
                        <div class="w-7/8">
                            <Input v-model="form.title" />
                            <InputError :message="form.errors.title" />
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