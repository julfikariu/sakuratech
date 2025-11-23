<script setup lang="ts">
import { Link } from '@inertiajs/vue3'

interface PaginationLink {
    url: string | null
    label: string
    active: boolean
}

interface Props{
    links: PaginationLink[];
    from: number;
    to: number;
    total: number;
}

const props = defineProps<Props>();
</script>

<template>
    <div class="border-t bg-gray-50 flex items-center justify-between p-3 gap-1 mt-3">
        <div class="text-sm text-gray-700">
            Showing {{ props.from }} to {{ props.to }} of {{ props.total }} results
        </div>
        <div class="flex justify-between items-center gap-1" aria-label="Pagination">
            <template v-for="(link, index) in links" :key="index">
                <!-- Skip "..." labels -->
                <span v-if="link.label.includes('...')" class="px-3 py-2 text-gray-500 select-none">
                    ...
                </span>

                <!-- Page link -->
                <Link v-else :href="link.url || '#'" :class="[
                    'inline-flex items-center justify-center min-w-[30px] px-2 py-1 rounded-md text-sm font-medium border transition-colors',
                    link.active
                        ? 'bg-primary text-primary-foreground border-primary hover:bg-primary/90'
                        : 'bg-background text-foreground border-input hover:bg-accent hover:text-accent-foreground',
                    !link.url && 'pointer-events-none opacity-50'
                ]">
                    <span v-html="link.label"></span>
                </Link>

            </template>
        </div>
    </div>
</template>
