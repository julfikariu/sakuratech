import { watch } from 'vue'
import { usePage } from '@inertiajs/vue3'
import { Toast } from '@/composables/useToast'

export function useFlashToast() {
    watch(
        () => usePage().props.flash,
        (flash: any) => {
            if (flash?.message) {
                Toast.fire({
                    icon: flash.type || 'success',
                    title: flash.message,
                })
            }
        },
        { immediate: true }
    )
}