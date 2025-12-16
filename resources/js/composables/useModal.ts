import { ref } from 'vue'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import axios from 'axios'
import type { DefineComponent } from 'vue'
import { markRaw } from 'vue'

type ModalState = {
    show: boolean
    props: Record<string, any>
    component: DefineComponent | null
}

const modal = ref<ModalState | null>(null);
const loading = ref(false); // Loading state for modal content
const loadingId = ref<number | null>(null) // track which button is loading

async function open(href: string, id?: number) {
    loading.value = true;
    loadingId.value = id ?? null // store clicked ID

    const inertiaMeta = document.querySelector('meta[name="inertia-version"]') as HTMLMetaElement | null
    const inertiaVersion = inertiaMeta?.content || ''

    const modulePages = import.meta.glob<DefineComponent>('/resources/js/pages/**/*.vue')

    try {
        const { data } = await axios.get(href, {
            headers: {
                'X-Inertia': 'true',
                'X-Inertia-Version': inertiaVersion,
                'X-Modal': 'true',
            },
        })

        const modulePath = Object.keys(modulePages).find(path =>
            path.endsWith(`${data.component}.vue`)
        )

        if (!modulePath) throw new Error('Component not found')

        const component = await resolvePageComponent(modulePath, modulePages)
        const resolved = component.default || component;

        modal.value = {
            show: true,
            props: data.props,
            component: markRaw(resolved),
        }
    } catch (error) {
        console.error('Failed to load modal:', error)
    } finally {
        loading.value = false; // Hide spinner once the component is loaded or failed
        loadingId.value = null // reset after load
    }
}

function close() {
    modal.value = null // Hide modal
}

export { modal, open, close, loading, loadingId };