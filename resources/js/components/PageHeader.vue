<script setup lang="ts">
import type { BreadcrumbItemType } from '@/types';
import Breadcrumbs from '@/components/Breadcrumbs.vue';

const props = withDefaults(
    defineProps<{
        title: string
        description?: string
        breadcrumbs?: BreadcrumbItemType[]
    }>(),
    {
        breadcrumbs: () => [],
    }
);
</script>

<template>
    <div class="flex items-center justify-between mb-4">

        <!-- Left Side -->
        <div class="flex items-center space-x-3">
            <div class="flex items-center space-x-2">
                <h2 class="text-xl font-bold">{{ props.title }}</h2>
                <small v-if="props.description" class="text-gray-500">
                    {{ props.description }}
                </small>
            </div>

            <slot></slot>
        </div>

        <!-- Breadcrumb Component -->
        <div>
            <template v-if="breadcrumbs && breadcrumbs.length > 0">
                    <Breadcrumbs :breadcrumbs="breadcrumbs" />
            </template>
        </div>
    </div>
</template>
