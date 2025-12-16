<script setup lang="ts">
import { RefreshCw, Search } from "lucide-vue-next";
import UserBranchDeptFilter from "@/components/UserBranchDeptFilter.vue";
import { Link,useForm } from '@inertiajs/vue3';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Label } from '@/components/ui/label';
import { index as ContactsIndex } from "@/routes/admin/contacts";
import { Button } from '@/components/ui/button';

const form = useForm({
    q: '',
})

// Apply filters
function applyFilters() {
    form.get(ContactsIndex().url, {
        preserveState: true,
        replace: true,
        preserveScroll: true
    });
}

</script>

<template>
    <form @submit.prevent="applyFilters" class="flex flex-wrap items-center justify-end gap-2 mb-6">

        <!-- Search -->
         <div class="grid gap-2">
            <div class="flex items-center6">
                <input type="text" v-model="form.q" placeholder="Search..."
                    class="h-9 px-2 border border-gray-300 rounded-l text-sm focus:outline-none" />
                <button @click="applyFilters"
                    class="h-9 w-9 flex items-center justify-center bg-green-600 text-white  hover:bg-green-700 cursor-pointer">
                    <Search class="w-4 h-4 text-white stroke-[2.5]" />
                </button>

                <Link :href="ContactsIndex().url">
                    <Button variant="reset" class="flex items-center gap-2 border-l-0 rounded-l-none h-9">
                        <RefreshCw class="w-4 h-4" />
                    </Button>
                </Link>
            </div>
         </div>
    </form>
</template>