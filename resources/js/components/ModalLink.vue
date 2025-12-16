<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { loadingId, open, loading } from '@/composables/useModal';
import { LoaderCircle } from 'lucide-vue-next';
import { computed } from 'vue';

const props = defineProps<{
    href: string;
    itemid?: number;
    variant?: string;
    size?: "sm" | "lg";
}>();

function handleClick(itemId?: number) {
    open(props.href, itemId); // Open the modal
}
const isLoading = computed(() => loadingId.value === props.itemid)

const buttonVariant = computed<"default" | "cancel" | "destructive" | "outline" | "secondary" | "ghost" | "link" | "green" | "yellow" | "assign" | "edit" | "delete">(() => {
    return props.variant ?? 'default';
});

</script>

<template>
    <!-- :disabled="isLoading" -->
    <Button variant="show" :size="props.size" type="button" @click="handleClick(props.itemid)" > 
        <!-- <template v-if="isLoading">
            <LoaderCircle class="w-4 h-4 animate-spin" />
        </template> -->
 
        <slot />
        
    </Button>
</template>
