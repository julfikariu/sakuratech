<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';

import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { dashboard } from "@/routes";
import { index as clients } from '@/routes/admin/clients';
import { index as contacts } from '@/routes/admin/contacts';
import { index as invoices } from '@/routes/admin/invoices';
import { index as payments } from '@/routes/admin/payments';
import { index as permissions } from '@/routes/admin/permission';
import { index as projects } from '@/routes/admin/projects';
import { index as roles } from '@/routes/admin/role';
import { index as tasks } from '@/routes/admin/tasks';
import { index as tickets } from '@/routes/admin/tickets';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import {
    ContactRound,
    Key,
    LayoutGrid,
    ListChecks,
    Receipt,
    SquareKanban,
    User,
    WalletCards
} from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: dashboard(),
        icon: LayoutGrid,
    },
    {
        title: 'Contacts',
        href: contacts(),
        icon: ContactRound,
    },
    {
        title: 'Roles',
        href: roles(),
        icon: ListChecks,
    },
    {
        title: 'Permissions',
        href: permissions(),
        icon: Key,
    },
    {
        title: 'Clients',
        href: clients(),
        icon: User,
    },
    {
        title: 'Projects',
        href: projects(),
        icon: SquareKanban,
    },
    {
        title: 'Tasks',
        href: tasks(),
        icon: ListChecks,
    },
    {
        title: 'Tickets',
        href: tickets(),
        icon: SquareKanban,
    },
    {
        title: 'Invoices',
        href: invoices(),
        icon: Receipt,
    },
    {
        title: 'Payments',
        href: payments(),
        icon: WalletCards,
    },
];

const footerNavItems: NavItem[] = [
    
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="dashboard()">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <!-- <NavUser /> -->
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
