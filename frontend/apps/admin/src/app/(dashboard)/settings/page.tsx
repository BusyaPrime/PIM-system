"use client";

import { Card, CardContent, CardHeader, CardTitle, CardDescription, Button } from "@omnipim/ui";
import { Settings, Globe, Database, Key } from "lucide-react";

export default function SettingsPage() {
    return (
        <div className="space-y-6">
            <div>
                <h2 className="text-3xl font-bold tracking-tight">System Settings</h2>
                <p className="text-muted-foreground">Global configuration for OmniPIM MAX platform.</p>
            </div>

            <div className="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <div className="col-span-1 space-y-2">
                    <button className="flex w-full items-center gap-2 rounded-lg bg-muted px-4 py-2 text-sm font-medium text-foreground">
                        <Globe className="h-4 w-4" /> Localization & Channels
                    </button>
                    <button className="flex w-full items-center gap-2 rounded-lg px-4 py-2 text-sm font-medium text-muted-foreground hover:bg-muted hover:text-foreground">
                        <Key className="h-4 w-4" /> API Credentials
                    </button>
                    <button className="flex w-full items-center gap-2 rounded-lg px-4 py-2 text-sm font-medium text-muted-foreground hover:bg-muted hover:text-foreground">
                        <Database className="h-4 w-4" /> Storage & Assets
                    </button>
                </div>

                <div className="col-span-3">
                    <Card>
                        <CardHeader>
                            <CardTitle>Localization & Channels</CardTitle>
                            <CardDescription>Configure supported languages and distribution endpoints.</CardDescription>
                        </CardHeader>
                        <CardContent className="space-y-6">
                            <div className="space-y-4">
                                <div>
                                    <h4 className="text-sm font-medium leading-none mb-2">Base Locale</h4>
                                    <div className="flex h-10 w-full rounded-md border border-input bg-transparent px-3 py-2 text-sm shadow-sm opacity-50 cursor-not-allowed">
                                        en_US
                                    </div>
                                </div>

                                <div className="pt-4">
                                    <h4 className="text-sm font-medium leading-none mb-3">Active Sales Channels</h4>
                                    <div className="flex flex-col gap-3">
                                        <div className="flex items-center justify-between border p-3 rounded-md">
                                            <span className="text-sm font-medium">Ecommerce Web</span>
                                            <span className="text-xs text-muted-foreground">en_US, fr_FR</span>
                                        </div>
                                        <div className="flex items-center justify-between border p-3 rounded-md">
                                            <span className="text-sm font-medium">Mobile App</span>
                                            <span className="text-xs text-muted-foreground">en_US</span>
                                        </div>
                                    </div>
                                </div>
                                <Button className="mt-4">Save Configuration</Button>
                            </div>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </div>
    );
}
