<script setup lang="ts">
import { Card, CardHeader, CardContent, CardFooter } from '@/components/ui/card'
import { computed, watch, onBeforeUnmount } from 'vue';

// Props
const props = defineProps<{
    show: boolean;
    title: string;
    size?: 'sm' | 'md' | 'lg' | 'xl' | 'full' | string; // string for custom like "800px"
}>();

// Typed emits
const emit = defineEmits<{
    (e: 'close'): void;
}>();

// Dynamic width based on size
const sizeClasses = computed(() => {
    switch (props.size) {
        case 'sm':
            return 'w-[400px]'
        case 'md':
            return 'w-[700px]'
        case 'lg':
            return 'w-[900px]'
        case 'xl':
            return 'w-[1100px]'
        case 'full':
            return 'w-full max-w-[95%]'
        default:
            return props.size ? `w-[${props.size}]` : 'w-[700px]' // support custom like "800px"
    }
})

watch(
  () => props.show,
  (visible) => {
    document.body.style.overflow = visible ? 'hidden' : ''
  },
  { immediate: true }
)

onBeforeUnmount(() => {
  document.body.style.overflow = ''
})

// Close handler
function close() {
    emit('close');
}
</script>

<template>

    <div v-if="show" class="fixed inset-0 bg-black/75 flex items-center justify-center z-50" role="dialog"
        aria-modal="true">

        <Card :class="['max-h-[90vh] py-2 gap-4 overflow-y-auto bg-white dark:bg-gray-900 shadow-lg rounded-lg', sizeClasses]">
            <!-- Header -->
            <CardHeader
                class="flex justify-between items-center px-3 !py-2 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold">{{ title }}</h2>
                <button @click="close"
                    class="text-gray-500 dark:text-gray-300 hover:text-red-700 dark:hover:text-red-500 text-2xl leading-none cursor-pointer"
                    aria-label="Close modal">
                    &times;
                </button>
            </CardHeader>
            <Transition name="modal">
                <!-- Body -->
                <CardContent class="overflow-x-auto max-h-[80vh] overflow-y-auto px-2">
                    <slot />
                </CardContent>
            </Transition>

            <!-- Footer (optional slot for actions) -->
            <CardFooter v-if="$slots.footer" class="border-t !py-2 border-gray-200 dark:border-gray-700">
                <slot name="footer" />
            </CardFooter>
        </Card>

    </div>

</template>


<style>
/* ------------------------------ */
/* Modal Card Scale Transition */
/* ------------------------------ */
.modal-enter-from,
.modal-leave-to {
    opacity: 0;
    transform: scale(0.95);
}

.modal-enter-active,
.modal-leave-active {
    transition: all 0.25s cubic-bezier(0.22, 1, 0.36, 1);
    /* nice spring-like easing */
}
</style>