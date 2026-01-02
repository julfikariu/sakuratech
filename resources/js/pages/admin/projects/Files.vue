<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import PageHeader from '@/components/PageHeader.vue';
import { dashboard } from "@/routes";
import TabMenu from './TabMenu.vue';
import { type BreadcrumbItem } from '@/types';
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card"
import Button from '@/components/ui/button/Button.vue';
import { Plus } from 'lucide-vue-next';
import Modal from '@/components/Modal.vue';
import { ref } from 'vue';
import UploadFile from '@/components/files/UploadFile.vue';


interface Project {
    id: number;
    name?: string;
}

const props = defineProps<{
    project: Project;
    files: any[];
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Projects',
        href: '/admin/projects',
    },
    {
        title: props.project.name ?? `Project #${props.project.id}`,
        href: '',
    },
];
const showModal = ref(false);

const close = () => {
    showModal.value = false;
};

const addNewFile = () => {
    showModal.value = true;
};
</script>

<template>
    <AppLayout>
        <div class="p-6">
            <PageHeader :title="`Project - ${props.project.name ?? ('#' + props.project.id)}`" description=""
                :breadcrumbs="breadcrumbs" />

            <TabMenu :project_id="props.project.id" />

            <div class="">
                <Card>
                    <CardHeader>                       
                        <Button variant="save" class="w-25" @click="addNewFile">
                            <Plus class="w-4 h-4 mr-2" />
                                Add New
                        </Button>
                    </CardHeader>

                    <CardContent class=" space-y-4 text-sm">
                        
                    </CardContent>
                </Card>
            </div>
        </div>

        <Modal :show="showModal" :size="'lg'" title="File Upload" @close="close">
            <UploadFile :project_id="props.project.id" @close="close"/>
        </Modal>
    </AppLayout>

</template>