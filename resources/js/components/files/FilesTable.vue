<script setup lang="ts">
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "@/components/ui/table";
import { Download, Trash2Icon } from "lucide-vue-next";
import { Button } from "@/components/ui/button";
import NoResults from "@/components/NoResults.vue";
import { deleteBySwal } from "@/composables/useSwal";
import { deleteFile as fileDelete } from "@/routes/admin/projects";


const props = defineProps<{
    files: any[];
}>();

</script>

<template>
    <div v-if="props.files && props.files.length > 0"
        class="overflow-x-auto  mt-3 bg-white dark:bg-gray-900 rounded shadow">
        <Table>
            <TableHeader>
                <TableRow>
                    <TableHead>Preview</TableHead>
                    <TableHead>File Name</TableHead>
                    <TableHead>Date</TableHead>    
                    <TableHead class="text-right">Actions</TableHead>
                </TableRow>
            </TableHeader>
            <TableBody>
                <TableRow v-for="item in props.files" :key="item.id">
                    <TableCell>
                         <img :src="`/storage/${item.path}`" alt="" class="h-10 w-10 object-cover rounded" />
                    </TableCell>
                    <TableCell>{{ item.name }}</TableCell>
                    <TableCell>{{ item.uploaded_at }}</TableCell>
            
                    <TableCell class="text-right flex gap-2 justify-end">

                    
                        <Button variant="download" size="sm" title="Download Invoice">
                            <Download class="w-4 h-4" />
                        </Button>

                        <Button @click="deleteBySwal(fileDelete(item.id).url, 'file')"
                            variant="delete" size="sm" title="Delete file">
                            <Trash2Icon class="w-4 h-4" />
                        </Button>
                    </TableCell>
                </TableRow>
            </TableBody>
        </Table>
    </div>
    <NoResults v-else />
</template>