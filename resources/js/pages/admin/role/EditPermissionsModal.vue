<script setup lang="ts">
import Modal from '@/components/Modal.vue';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import type { Role } from '@/types/models';
import { useForm } from '@inertiajs/vue3';
import { Search, ShieldCheck } from 'lucide-vue-next';
import { computed, ref, watch } from 'vue';
import { updatePermissions } from '@/actions/App/Http/Controllers/Admin/RoleController';

// Spatie Permission Interface
interface Permission {
    id: number;
    name: string;
    guard_name: string;
}

interface Props {
    show: boolean;
    role: Role & { permissions?: Permission[] };
    allPermissions: Permission[];
}

const props = defineProps<Props>();
const emit = defineEmits(['close']);

// ---------------------------------------------------------------------------
// State
// ---------------------------------------------------------------------------
const searchQuery = ref('');

// Inertia Form: We use permission names as Spatie syncs best with strings
const form = useForm({
    permissions: [] as string[],
});

// ---------------------------------------------------------------------------
// Computed
// ---------------------------------------------------------------------------

// Filter permissions based on search input
const filteredPermissions = computed(() => {
    const query = searchQuery.value.toLowerCase().trim();
    if (!query) return props.allPermissions;
    return props.allPermissions.filter(p =>
        p.name.toLowerCase().includes(query)
    );
});

// Global counts
const totalPermissionsCount = computed(() => props.allPermissions.length);
const selectedPermissionsCount = computed(() => form.permissions.length);

// Logic for "Select All" based on currently FILTERED list
const selectedInCurrent = computed(() =>
    filteredPermissions.value.filter(p => form.permissions.includes(p.name)).length
);

const isAllSelected = computed(() => {
    return filteredPermissions.value.length > 0 &&
           selectedInCurrent.value === filteredPermissions.value.length;
});

const isIndeterminate = computed(() => {
    return selectedInCurrent.value > 0 &&
           selectedInCurrent.value < filteredPermissions.value.length;
});

// ---------------------------------------------------------------------------
// Watchers
// ---------------------------------------------------------------------------

// Sync form state when the role prop changes (e.g., opening a different role)
watch(() => props.role, (newRole) => {
    if (newRole && newRole.permissions) {
        form.permissions = newRole.permissions.map(p => p.name);
    } else {
        form.permissions = [];
    }
}, { immediate: true });

// ---------------------------------------------------------------------------
// Actions
// ---------------------------------------------------------------------------

function togglePermission(name: string) {
    const index = form.permissions.indexOf(name);
    if (index > -1) {
        form.permissions.splice(index, 1);
    } else {
        form.permissions.push(name);
    }
}

function toggleSelectAll() {
    const currentNames = filteredPermissions.value.map(p => p.name);

    if (isAllSelected.value) {
        // Remove only the currently visible permissions from the selection
        form.permissions = form.permissions.filter(name => !currentNames.includes(name));
    } else {
        // Add currently visible permissions, ensuring no duplicates
        const uniqueNames = new Set([...form.permissions, ...currentNames]);
        form.permissions = Array.from(uniqueNames);
    }
}

function submit() {
    // Assuming you have a route helper or use a hardcoded string
    // Replace the URL logic with your actual route path if 'wayfinder' isn't global
    form.put(updatePermissions.url({ role: props.role.id }), {
        preserveScroll: true,
        onSuccess: () => emit('close'),
        onError: (err) => console.error('Update failed:', err),
    });
}
</script>

<template>
    <Modal
        :show="show"
        :title="`Manage Permissions: ${role.name}`"
        size="lg"
        @close="emit('close')"
    >
        <div class="space-y-4 px-1">
            <div class="flex flex-col gap-4 bg-secondary/10 p-4 rounded-lg border">
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                    <div class="relative w-full sm:w-72">
                        <Search class="absolute left-2.5 top-2.5 h-4 w-4 text-muted-foreground" />
                        <Input
                            v-model="searchQuery"
                            placeholder="Search permissions..."
                            class="pl-9 bg-background"
                        />
                    </div>
                    <Badge variant="outline" class="font-mono h-9 px-3">
                        {{ selectedPermissionsCount }} selected / {{ totalPermissionsCount }} total
                    </Badge>
                </div>

                <div class="flex items-center space-x-2 border-t pt-3 mt-1">
                    <input
                        id="select-all-main"
                        type="checkbox"
                        :checked="isAllSelected"
                        :indeterminate="isIndeterminate"
                        @change="toggleSelectAll"
                        class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary cursor-pointer"
                    />
                    <Label for="select-all-main" class="text-sm font-bold cursor-pointer select-none">
                        Select All Visible ({{ filteredPermissions.length }})
                    </Label>
                </div>
            </div>

            <div class="h-[50vh] overflow-y-auto pr-2 custom-scrollbar border rounded-md p-4 bg-card">
                <div v-if="filteredPermissions.length === 0" class="flex flex-col items-center justify-center py-10 text-muted-foreground">
                    <ShieldCheck class="w-12 h-12 mb-2 opacity-20" />
                    <p>No permissions found matching "{{ searchQuery }}"</p>
                </div>

                <div v-else class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-3">
                    <div
                        v-for="perm in filteredPermissions"
                        :key="perm.id"
                        class="flex items-start space-x-2 p-2 rounded hover:bg-accent/50 transition-colors group"
                    >
                        <input
                            :id="`perm-${perm.id}`"
                            type="checkbox"
                            :checked="form.permissions.includes(perm.name)"
                            @change="togglePermission(perm.name)"
                            class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary cursor-pointer mt-0.5"
                        />
                        <Label
                            :for="`perm-${perm.id}`"
                            class="text-sm cursor-pointer leading-tight select-none w-full group-hover:text-primary transition-colors"
                        >
                            {{ perm.name }}
                        </Label>
                    </div>
                </div>
            </div>
        </div>

        <template #footer>
            <div class="flex justify-between w-full gap-4">
                <Button variant="outline" @click="emit('close')">
                    Cancel
                </Button>
                <Button
                    @click="submit"
                    :disabled="form.processing"
                    class="w-40"
                >
                    <span v-if="form.processing">Saving...</span>
                    <span v-else>Save Changes</span>
                </Button>
            </div>
        </template>
    </Modal>
</template>

<style scoped>
.custom-scrollbar::-webkit-scrollbar {
    width: 6px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background-color: rgba(156, 163, 175, 0.5);
    border-radius: 20px;
}
</style>
