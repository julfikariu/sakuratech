<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { X, Save, LoaderCircle } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import Label from '@/components/ui/label/Label.vue';
import InputError from '@/components/InputError.vue';
import FileUpload from '@/components/FileUpload.vue';
import RequiredSign from '@/components/RequiredSign.vue';
import { ref, watch } from 'vue';
import { uploadFile as projectUploadFile } from '@/routes/admin/projects';


const props = defineProps<{
    project_id: number;
}>();

const emit = defineEmits<{
    (e: 'close'): void;
}>();

const files = ref<File[]>([]);

watch(files, (newFiles) => {
    form.files = [...newFiles];
});

const form = useForm({
    user_id: '' as number | '',
    project_id: props.project_id,
    files: [] as File[],
});

function submitForm() {
    // Files are already attached to form (watch above). Use form.post with forceFormData
    form.post(projectUploadFile.url(props.project_id), {
        forceFormData: true,
        onSuccess: () => {
            form.reset();
            files.value = [];
            closeModal();
          
        }
    });
}

function closeModal() {
    emit('close');
}

</script>

<template>
    <div class="pb-6">
            <form @submit.prevent="submitForm" enctype="multipart/form-data">
                <div class="grid gap-6">   
                                                

                    <div class="flex items-center">
                        <Label class="w-1/8 justify-end mr-4"> <RequiredSign /> Attachment :</Label>
                        <div class="w-7/8">
                            <FileUpload v-model:files="files" :multiple="true" />
                            <InputError class="mt-2" :message="form.errors.files" />
                        </div>
                    </div>

                    <div class="flex items-center">
                        <Label class="w-1/8 justify-end mr-4"></Label>
                        <div class="flex gap-2 w-1/12">
                            <Button type="submit"  variant="save" :disabled="form.processing">
                                <LoaderCircle v-if="form.processing" class="w-4 h-4 animate-spin mr-2" />
                                <Save v-else class="w-4 h-4" />
                                Save
                            </Button>
                            <Button type="button" class="cursor-pointer" variant="secondary"
                                @click.prevent="closeModal">
                                <X class="w-4 h-4" />
                                Cancel
                            </Button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
</template>
