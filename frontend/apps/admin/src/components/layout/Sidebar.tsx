"use client";

import Link from "next/link";
import { usePathname } from "next/navigation";
import { cn } from "@omnipim/ui";
import { useTranslation } from "@/components/providers/I18nProvider";
import {
    Package,
    Settings,
    LayoutGrid,
    Workflow,
    Folders,
    Database,
    Search,
    Users
} from "lucide-react";

export function Sidebar() {
    const pathname = usePathname();
    const { t } = useTranslation();

    const routes = [
        { name: t("dashboard"), icon: LayoutGrid, path: "/" },
        { name: t("catalog"), icon: Package, path: "/catalog" },
        { name: t("taxonomy"), icon: Folders, path: "/taxonomy" },
        { name: t("quality"), icon: Database, path: "/quality" },
        { name: t("jobs"), icon: Workflow, path: "/jobs" },
        { name: t("revisions"), icon: Search, path: "/revisions" },
        { name: t("workflows"), icon: Workflow, path: "/workflows" },
        { name: t("users"), icon: Users, path: "/users" },
        { name: t("settings"), icon: Settings, path: "/settings" },
    ];

    return (
        <div className="flex h-full w-64 flex-col border-r bg-card px-3 py-4">
            <div className="mb-8 px-4">
                <h1 className="text-2xl font-bold Tracking-tight text-primary">OmniPIM MAX</h1>
            </div>
            <nav className="flex-1 space-y-1">
                {routes.map((route) => {
                    const isActive = pathname === route.path || pathname.startsWith(`${route.path}/`);
                    return (
                        <Link
                            key={route.path}
                            href={route.path}
                            className={cn(
                                "flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition-all",
                                isActive
                                    ? "bg-primary text-primary-foreground"
                                    : "text-muted-foreground hover:bg-muted hover:text-foreground"
                            )}
                        >
                            <route.icon className="h-4 w-4" />
                            {route.name}
                        </Link>
                    );
                })}
            </nav>
            <div className="mt-auto px-4 py-2 text-xs text-muted-foreground">
                Version 1.0.0-enterprise
            </div>
        </div>
    );
}
