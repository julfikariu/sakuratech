<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Button } from '@/components/ui/button';
import InputError from '@/components/InputError.vue';
import { Toast } from '@/composables/useToast';
import { LoaderCircle, Save, X } from 'lucide-vue-next';
import type { Role } from '@/types/models';
import { store as roleStore, update as roleUpdate } from '@/routes/admin/role';


interface Props {
    mode: 'create' | 'edit';
    role?: Role | null;
};

const props = defineProps<Props>();

const emit = defineEmits<{
    (e: 'closemodal'): void;
}>();

const form = useForm({
    id: props.role?.id || 0,
    name: props.role?.name || '',
    description: props.role?.description || ''
});

// action
function submitForm() {
    if (props.mode === 'create') {
        form.submit(roleStore(), {
            onSuccess: () => {
                form.reset();
                Toast.fire({
                    icon: 'success',
                    title: 'Role created successfully!',
                });
                emit('closemodal');
            },
        });
    } else {
        form.submit(roleUpdate({ id: form.id }), {
            onSuccess: () => {
                Toast.fire({
                    icon: 'success',
                    title: 'User updated successfully!',
                });
                emit('closemodal');
            },
            onError: () => {
                Toast.fire({
                    icon: 'error',
                    title: 'Failed to update!',
                });
            },
        });
    }
}
</script>

<template>
    <div class="p-4">
        <form @submit.prevent="submitForm">
        <div class="grid gap-6">
            <!-- Name -->
            <div class="grid gap-2">
                <Label for="name">Name</Label>
                <Input v-model="form.name" id="name" type="text" placeholder="Full name" />
                <InputError :message="form.errors.name" />
            </div>

            <div class="grid gap-2">
                <Label for="description">Description</Label>
                <Input v-model="form.description" id="description" type="text" placeholder="Description" />
                <InputError :message="form.errors.description" />
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex items-center mt-6">
            <div class="flex gap-2 ">
                <Button type="submit"  variant="save" :disabled="form.processing">
                    <LoaderCircle v-if="form.processing" class="w-4 h-4 animate-spin" />
                    <Save v-else class="w-4 h-4" />
                    Save
                </Button>
                <Button type="button" class="cursor-pointer" variant="secondary"
                    @click.prevent="emit('closemodal')">
                    <X class="w-4 h-4" />
                    Cancel
                </Button>
            </div>
        </div>
    </form>
    </div>
</template>
