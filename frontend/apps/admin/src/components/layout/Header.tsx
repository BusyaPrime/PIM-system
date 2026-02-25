"use client";

import Link from "next/link";
import { Bell, User } from "lucide-react";
import { Button } from "@omnipim/ui";
import { useTranslation } from "@/components/providers/I18nProvider";

export function Header() {
    const { t } = useTranslation();

    return (
        <header className="flex h-14 items-center justify-between border-b bg-card px-6">
            <div className="flex flex-1 items-center">
                <span className="text-sm text-muted-foreground">OmniPIM MAX / {t("dashboard")}</span>
            </div>
            <div className="flex items-center gap-4">
                <div className="relative hidden md:block w-64">
                    <input
                        type="text"
                        placeholder={t("search")}
                        className="flex h-9 w-full rounded-md border border-input bg-background px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50"
                    />
                </div>
                <Button variant="ghost" size="icon">
                    <Bell className="h-5 w-5" />
                    <span className="sr-only">Notifications</span>
                </Button>
                <Link href="/profile" title={t("profile")}>
                    <Button variant="ghost" size="icon" className="rounded-full bg-primary/10 text-primary hover:bg-primary/20">
                        <User className="h-5 w-5" />
                        <span className="sr-only">{t("profile")}</span>
                    </Button>
                </Link>
            </div>
        </header>
    );
}
