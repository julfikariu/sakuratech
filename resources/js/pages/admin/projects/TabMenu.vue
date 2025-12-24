<script setup lang="ts">
import { User, FileEdit, FolderOpen, Bell, FileText, Mail, ListChecks, RefreshCcw } from "lucide-vue-next";
import { Separator } from "@/components/ui/separator";
import { Link, usePage } from "@inertiajs/vue3";


const page = usePage();

// Get the staff project_id from page props

interface Props {
    project_id: number;
}

const props = defineProps<Props>();

const view_profile = 'profile/' + props.project_id;
const staff_files = 'staff/' + props.project_id + '/files';
const change_password =  'staff/' + props.project_id + '/change-password';

const tabs = [
    { icon: User, label: "Details", route: view_profile },
    { icon: FolderOpen, label: "Files", route: staff_files },
    { icon: RefreshCcw, label: "Change Password", route: change_password },
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