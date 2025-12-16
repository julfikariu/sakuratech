<script setup lang="ts">
import AppLayout from '@/layouts/app/AppSidebarLayout.vue';
import { useFlashToast } from '@/composables/useFlashToast'
import { modal, open, close, loading } from '@/composables/useModal'

useFlashToast();
</script>

<template>

    <!-- Global Modal -->
    <transition name="modal" appear>
        <template v-if="modal && modal.show">
            <component :is="modal.component" :show="modal.show" v-bind="modal.props" @close="close" />
        </template>
    </transition>

    <!-- Global Loading Overlay -->
    <transition name="fade">
        <div v-if="loading" class="fixed inset-0 z-50 flex items-center justify-center bg-white/60">
            <!-- Spinner -->
            <div
                class="animate-spin h-16 w-16 border-4 border-t-blue-500 border-b-blue-500 border-l-transparent border-r-transparent rounded-full">
            </div>

            <!-- Optional Loading Text -->
            <!-- <span class="ml-4 text-blue-700 text-lg font-medium">Loading...</span> -->
        </div>
    </transition>

    <AppLayout>        
        <slot />
    </AppLayout>
</template>
