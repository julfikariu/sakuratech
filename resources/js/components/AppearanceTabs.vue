<script setup lang="ts">
import { useAppearance } from '@/composables/useAppearance';
import { Moon, Sun } from 'lucide-vue-next';

const { appearance, updateAppearance } = useAppearance();

const toggleAppearance = () => {
    const newAppearance = (appearance.value == 'light' ? 'dark' : 'light');
    updateAppearance(newAppearance);
};

</script>

<template>
    <button @click="toggleAppearance" :class="[
        'flex items-center justify-center rounded-lg p-2 transition-colors cursor-pointer',
        'bg-neutral-100 hover:bg-neutral-200/60 dark:bg-neutral-800 dark:hover:bg-neutral-700/60',
        'text-neutral-500 hover:text-black dark:text-neutral-400 dark:hover:text-neutral-100'
    ]" :title="appearance === 'light' ? 'Switch to dark mode' : 'Switch to light mode'">
        <Moon v-if="appearance === 'light'" class="h-4 w-4" />
        <Sun v-else class="h-4 w-4" />
    </button>
</template>
