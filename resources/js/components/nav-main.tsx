import { SidebarGroup, SidebarGroupLabel, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/react';
import { AnimatePresence, motion } from 'framer-motion';
import { useState } from 'react';

export function NavMain({ items = [] }: { items: NavItem[] }) {
    const page = usePage();
    const [openDropdown, setOpenDropdown] = useState<string | null>(null);

    const handleDropdownClick = (title: string) => {
        setOpenDropdown((prev) => (prev === title ? null : title));
    };

    return (
        <SidebarGroup className="px-2 py-0">
            <SidebarGroupLabel>Platform</SidebarGroupLabel>
            <SidebarMenu>
                {items.map((item) =>
                    item.isDropdown && item.children ? (
                        <SidebarMenuItem key={item.title} className="relative">
                            <SidebarMenuButton asChild tooltip={{ children: item.title }} onClick={() => handleDropdownClick(item.title)}>
                                <button type="button" className="flex w-full items-center gap-2">
                                    {item.icon && <item.icon className="h-5 w-5" />}
                                    <span>{item.title}</span>
                                    <span className="ml-auto">{openDropdown === item.title ? '▲' : '▼'}</span>
                                </button>
                            </SidebarMenuButton>
                            <AnimatePresence initial={false}>
                                {openDropdown === item.title && (
                                    <motion.div
                                        initial={{ opacity: 0, height: 0 }}
                                        animate={{ opacity: 1, height: 'auto' }}
                                        exit={{ opacity: 0, height: 0 }}
                                        transition={{ duration: 0.2 }}
                                    >
                                        <SidebarMenu className="mt-1 ml-4">
                                            {item.children.map((child) => (
                                                <SidebarMenuItem key={child.title}>
                                                    <SidebarMenuButton
                                                        asChild
                                                        isActive={page.url.startsWith(child.href ?? '')}
                                                        tooltip={{ children: child.title }}
                                                    >
                                                        <Link href={child.href} prefetch className="flex items-center gap-2">
                                                            {child.icon && <child.icon className="h-4 w-4" />}
                                                            <span>{child.title}</span>
                                                        </Link>
                                                    </SidebarMenuButton>
                                                </SidebarMenuItem>
                                            ))}
                                        </SidebarMenu>
                                    </motion.div>
                                )}
                            </AnimatePresence>
                        </SidebarMenuItem>
                    ) : (
                        <SidebarMenuItem key={item.title}>
                            <SidebarMenuButton asChild isActive={page.url.startsWith(item.href ?? '')} tooltip={{ children: item.title }}>
                                <Link href={item.href} prefetch className="flex items-center gap-2">
                                    {item.icon && <item.icon className="h-5 w-5" />}
                                    <span>{item.title}</span>
                                </Link>
                            </SidebarMenuButton>
                        </SidebarMenuItem>
                    ),
                )}
            </SidebarMenu>
        </SidebarGroup>
    );
}
