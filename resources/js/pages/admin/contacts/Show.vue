<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import Modal from '@/components/Modal.vue';
import { modal, close } from '@/composables/useModal';
import { X } from 'lucide-vue-next';
import { type Contact } from '@/types/models';

const props = defineProps<{
    contact: Contact;
}>();
</script>

<template>
    <Modal :show="true" :size="'lg'" title="Contact Details" @close="close">
        <div class="pb-6 px-4">
            <div class="grid gap-6">
                <!-- Name -->
                <div class="flex items-center">
                    <Label class="w-1/4 text-right mr-4 font-bold text-gray-700">Name :</Label>
                    <div class="w-3/4 text-gray-800">{{ props.contact.name }}</div>
                </div>

                <!-- Email -->
                <div class="flex items-center">
                    <Label class="w-1/4 text-right mr-4 font-bold text-gray-700">Email :</Label>
                    <div class="w-3/4 text-gray-800">{{ props.contact.email }}</div>
                </div>

                <!-- Subject -->
                <div class="flex items-center">
                    <Label class="w-1/4 text-right mr-4 font-bold text-gray-700">Subject :</Label>
                    <div class="w-3/4 text-gray-800">{{ props.contact.subject || 'N/A' }}</div>
                </div>

                <!-- Message -->
                <div class="flex items-start">
                    <Label class="w-1/4 text-right mr-4 font-bold text-gray-700 mt-1">Message :</Label>
                    <div class="w-3/4 text-gray-800 whitespace-pre-wrap">{{ props.contact.message }}</div>
                </div>

                <!-- Date -->
                <div class="flex items-center">
                    <Label class="w-1/4 text-right mr-4 font-bold text-gray-700">Submitted At :</Label>
                    <div class="w-3/4 text-gray-800">{{ props.contact.created_at }}</div>
                </div>

                <!-- Close Button -->
                <div class="flex justify-end mt-4 border-t pt-4">
                    <Button type="button" variant="secondary" @click.prevent="close">
                        <X class="w-4 h-4 mr-2" /> Close
                    </Button>
                </div>
            </div>
        </div>
    </Modal>
</template>
