<script setup lang="ts">
import PageHeader from '@/components/PageHeader.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import { Form, Link, router } from '@inertiajs/vue3';
import { ChevronRight, Eye, EyeOff, Home } from 'lucide-vue-next';
import { computed, ref, watch } from 'vue';
import { type BreadcrumbItem } from '@/types';
import { dashboard } from "@/routes";
import { index as clientsIndex } from '@/routes/admin/clients';
import { changePassword as clientsChangePassword } from '@/routes/admin/clients';
import TabMenu from './TabMenu.vue';

interface Client {
    id: number;
    company_name?: string;
    email?: string;
}

interface Props {
    client: Client;
}

const props = defineProps<Props>()

    const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Clients',
        href: clientsIndex().url,
    },
    {
        title: props.client.company_name ?? `Client #${props.client.id}`,
        href: '',
    },
];

const passwordInput = ref<HTMLInputElement | null>(null);

// Password fields
const password = ref('')
const passwordVisible = ref(false)
const passwordVisible2 = ref(false)

// Password strength
const passwordStrength = ref('')
const passwordHint = 'Password must be 8-12 characters long and include letters and numbers.'

watch(password, (val) => {
    passwordStrength.value = getPasswordStrength(val)
})

function getPasswordStrength(p: string) {
    if (!p) return ''
    const lengthValid = p.length >= 8 && p.length <= 12
    const hasUpper = /[A-Z]/.test(p)
    const hasLower = /[a-z]/.test(p)
    const hasNumber = /\d/.test(p)
    const hasSpecial = /[!@#$%^&*()_+\-=[\]{};':"\\|,.<>/?]/.test(p)

    let score = 0
    if (lengthValid) score++
    if (hasUpper) score++
    if (hasLower) score++
    if (hasNumber) score++
    if (hasSpecial) score++

    if (!lengthValid) return 'Invalid length'
    if (score <= 2) return 'Weak'
    if (score === 3 || score === 4) return 'Medium'
    return 'Strong'
}

const strengthColor = computed(() => {
    switch (passwordStrength.value) {
        case 'Weak':
            return 'bg-red-500'
        case 'Medium':
            return 'bg-yellow-400'
        case 'Strong':
            return 'bg-green-500'
        default:
            return 'bg-gray-300'
    }
})

</script>

<template>
    <AppLayout>
        <div class="p-6">
            <PageHeader :title="`Client - ${props.client.company_name ?? ('#' + props.client.id)}`" description="" :breadcrumbs="breadcrumbs" />

            <TabMenu :client_id="props.client.id" />

            <Card>
                <CardHeader>
                    <CardTitle>Change Password</CardTitle>
                </CardHeader>
                <CardContent>
                    <div class="w-1/2">
                        <div class="space-y-6">

                            <Form method="post" :action="clientsChangePassword.url(props.client.id)" :options="{
                                preserveScroll: true,
                            }" reset-on-success :reset-on-error="['password', 'password_confirmation']"
                                class="space-y-6" v-slot="{ errors, processing, recentlySuccessful }">
                                <div v-show="recentlySuccessful"
                                    class="text-sm text-white bg-green-500 p-3 w-70 rounded-md">Password changed
                                    successfully.</div>

                                <input type="hidden" name="user_id" :value="props.client.id" />

                                <div class="flex items-center gap-3">
                                    <Label class="w-2/8 justify-end">Name :</Label>
                                    <div class="w-6/8">
                                        <div class="flex items-center border rounded">
                                            <span class="p-2 text-sm text-gray-600">{{ props.client.company_name }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <Label class="w-2/8 justify-end">Email :</Label>
                                    <div class="w-6/8">
                                        <div class="flex items-center border rounded">
                                            <span class="p-2 text-sm text-gray-600">{{ props.client.email }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center gap-3">
                                    <Label class="w-2/8 justify-end">New password :</Label>
                                    <div class="w-6/8">
                                        <div class="relative">
                                            <Input id="password" ref="passwordInput" name="password" maxlength="12"
                                                :type="passwordVisible ? 'text' : 'password'" class="block w-full mt-1"
                                                autocomplete="new-password" placeholder="New password"
                                                v-model="password" 
                                            />
                                            <!-- Eye Icon to toggle password visibility -->
                                            <span @click="passwordVisible = !passwordVisible"
                                                class="absolute inset-y-0 end-0 flex items-center z-20 px-3 cursor-pointer text-gray-400 rounded-e-md focus:outline-hidden">
                                                <Eye v-if="passwordVisible" class="w-4 h-4" />
                                                <EyeOff v-else class="w-4 h-4" />
                                            </span>
                                        </div>
                                        <!-- Password strength bar -->
                                        <div class="mt-2 flex items-center gap-2">
                                            <div class="flex-1 h-2 rounded bg-gray-200 overflow-hidden">
                                                <div :class="['h-2 rounded', strengthColor]"
                                                    :style="{ width: password ? '100%' : '0%' }"></div>
                                            </div>
                                            <span class="text-sm text-gray-500">{{ passwordStrength }}</span>
                                        </div>
                                        <p class="text-xs text-gray-400 mt-1">{{ passwordHint }}</p>

                                        <InputError :message="errors.password" />
                                    </div>
                                </div>

                                <div class="flex items-center gap-3">
                                    <Label class="w-2/8 justify-end">Confirm password :</Label>
                                    <div class="w-6/8">
                                        <div class="relative">
                                            <Input id="password_confirmation" name="password_confirmation"
                                                :type="passwordVisible2 ? 'text' : 'password'" class="block w-full mt-1"
                                                autocomplete="new-password" placeholder="Confirm password" />
                                            <!-- Eye Icon to toggle password visibility -->
                                            <span @click="passwordVisible2 = !passwordVisible2"
                                                class="absolute inset-y-0 end-0 flex items-center z-20 px-3 cursor-pointer text-gray-400 rounded-e-md focus:outline-hidden">
                                                <Eye v-if="passwordVisible2" class="w-4 h-4" />
                                                <EyeOff v-else class="w-4 h-4" />
                                            </span>
                                        </div>

                                        <InputError :message="errors.password_confirmation" />
                                    </div>
                                </div>

                                <div class="flex items-center gap-4">
                                    <div class="w-2/8"></div>
                                    <div class="w-6/8">
                                        <Button variant="save" :disabled="processing">Update password</Button>

                                        <Transition enter-active-class="transition ease-in-out"
                                            enter-from-class="opacity-0" leave-active-class="transition ease-in-out"
                                            leave-to-class="opacity-0">
                                        </Transition>
                                    </div>

                                </div>
                            </Form>
                        </div>
                    </div>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>