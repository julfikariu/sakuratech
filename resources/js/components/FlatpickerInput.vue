<script lang="ts" setup>
import { onMounted } from 'vue'
import { useVModel } from '@vueuse/core'
import flatpickr from 'flatpickr'
import 'flatpickr/dist/flatpickr.min.css'
import { Input } from '@/components/ui/input'
import type { HTMLAttributes } from 'vue'

const props = defineProps<{
    defaultValue?: string
    modelValue?: string
    placeholder?: string
    class?: HTMLAttributes['class']
}>();

const emits = defineEmits<{
  (e: 'update:modelValue', payload: string | number): void
}>();

const modelValue = useVModel(props, 'modelValue', emits, {
    passive: true,
    defaultValue: props.defaultValue,
});

onMounted(() => {
    // Initialize start date picker
    flatpickr(".flat_picker", {
        dateFormat: "d-M-Y",
        allowInput: true,
        enableTime: false,
    });
});

</script>

<template>
    <Input 
        v-model="modelValue"
        type="text"
        :placeholder="placeholder" 
        class="flat_picker"
        :class="props.class" />
</template>
