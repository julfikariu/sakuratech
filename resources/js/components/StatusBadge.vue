<script setup lang="ts">
import { computed } from 'vue';

interface Props {
    status?: string | null
}

const props = defineProps<Props>()

const classes = computed(() => {
    switch (props.status) {
        case 'Active':
            return 'text-green-600 bg-green-100'
        case 'Publish':
            return 'text-green-600 bg-green-100'
        case 'Approved':
            return 'text-green-600 bg-green-100'
        case 'Inactive':
            return 'text-red-600 bg-red-100'
        case 'Cancelled':
            return 'text-red-600 bg-red-100'
        case 'Cancel':
            return 'text-red-600 bg-red-100'
        case 'Archive':
            return 'text-blue-600 bg-blue-100'
        case 'Pending':
            return 'text-blue-600 bg-blue-100'
        case 'Suspended':
            return 'text-red-600 bg-red-100'
        case 'Unlock':
            return 'text-green-600 bg-green-100'
        default:
            return 'text-gray-600 bg-gray-100'
    }
})
</script>

<template>
    <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium" :class="classes">
        {{ props.status }}
    </span>
</template>
