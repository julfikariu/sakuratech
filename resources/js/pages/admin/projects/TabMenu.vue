<script setup lang="ts">
import { Separator } from '@/components/ui/separator';
import { Link, usePage } from '@inertiajs/vue3';
import { FileText, FolderOpen, RefreshCcw, User } from 'lucide-vue-next';

const page = usePage();

interface Props {
    project_id: number;
}

const props = defineProps<Props>();

const view_details = '/admin/projects/' + props.project_id;
const view_projects = '/admin/projects/' + props.project_id + '/files';
const view_invoices = '/admin/projects/' + props.project_id + '/tasks';
const change_password = '/admin/projects/' + props.project_id + '/milestone';

const tabs = [
    { icon: User, label: 'Details', route: view_details },
    { icon: FolderOpen, label: 'Files', route: view_projects },
    { icon: FileText, label: 'Tasks', route: view_invoices },
    { icon: RefreshCcw, label: 'Milestones', route: change_password },
];

const isTabActive = (tab: string) => {
    const tabPath = new URL(tab, window.location.origin).pathname;
    const currentPath = new URL(page.url, window.location.origin).pathname;
    return tabPath === currentPath;
};
</script>

<template>
    <div class="bg-white py-4">
        <nav class="flex flex-wrap items-center gap-6 text-sm font-medium text-gray-700">
            <template v-for="(tab, index) in tabs" :key="index">
                <Link :href="tab.route"
                    class="flex items-center gap-2 border-b-2 pb-1 transition-all duration-200 cursor-pointer" :class="isTabActive(tab.route)
                        ? 'border-green-500 text-green-600 font-semibold'
                        : 'border-transparent hover:text-green-600 hover:border-green-400'">
                <component :is="tab.icon" class="w-4 h-4" />
                <span>{{ tab.label }}</span>
                </Link>
            </template>
        </nav>

        <Separator class="mt-3" />
    </div>
</template>
