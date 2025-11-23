<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Toast } from '@/composables/useToast';
import { store as permissionStore, update as permissionUpdate } from '@/routes/admin/permission';
import { useForm } from '@inertiajs/vue3';
import { LoaderCircle, Save, X } from 'lucide-vue-next';

interface Props {
    mode: 'create' | 'edit';
    permission?: { id: number; name: string } | null;
};

const props = defineProps<Props>();

const emit = defineEmits<{
    (e: 'closemodal'): void;
}>();

const form = useForm({
    id: props.permission?.id || 0,
    name: props.permission?.name || '',
});

function submitForm() {
    if (props.mode === 'create') {
        form.submit(permissionStore(), {
            onSuccess: () => {
                form.reset();
                Toast.fire({ icon: 'success', title: 'Permission created successfully!' });
                emit('closemodal');
            },
        });
    } else {
        form.submit(permissionUpdate({ id: form.id }), {
            onSuccess: () => {
                Toast.fire({ icon: 'success', title: 'Permission updated successfully!' });
                emit('closemodal');
            },
            onError: () => {
                Toast.fire({ icon: 'error', title: 'Failed to update!' });
            },
        });
    }
}
</script>

<template>
    <div class="p-4">
        <form @submit.prevent="submitForm">
            <div class="grid gap-6">
                <div class="grid gap-2">
                    <Label for="name">Name</Label>
                    <Input v-model="form.name" id="name" type="text" placeholder="Permission name" />
                    <InputError :message="form.errors.name" />
                </div>
            </div>

            <div class="flex items-center mt-6">
                <div class="flex gap-2 ">
                    <Button type="submit" variant="save" :disabled="form.processing">
                        <LoaderCircle v-if="form.processing" class="w-4 h-4 animate-spin" />
                        <Save v-else class="w-4 h-4" />
                        Save
                    </Button>
                    <Button type="button" class="cursor-pointer" variant="secondary" @click.prevent="emit('closemodal')">
                        <X class="w-4 h-4" />
                        Cancel
                    </Button>
                </div>
            </div>
        </form>
    </div>
</template>
