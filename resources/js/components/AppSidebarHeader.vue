<script setup lang="ts">
import { SidebarTrigger } from '@/components/ui/sidebar';
import NavUser from '@/components/NavUser.vue';
import AppearanceTabs from '@/components/AppearanceTabs.vue';
</script>

<template>
    <header
        class="flex h-16 shrink-0 items-center gap-2 border-b border-sidebar-border/70 px-6 transition-[width,height] ease-linear group-has-data-[collapsible=icon]/sidebar-wrapper:h-12 md:px-4"
    >
        <div class="flex items-center justify-between w-full gap-2">
        
            <div class="flex items-center  gap-2">
                <SidebarTrigger class="-ml-1" />
            </div>

            <div class="flex items-center gap-2">
                <AppearanceTabs /> 
                <NavUser />
            </div>
            
        </div>
        
    </header>
</template>
