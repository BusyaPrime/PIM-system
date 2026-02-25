"use client";

import { useState } from "react";
import { Button, Card, CardHeader, CardTitle, CardDescription, CardContent } from "@omnipim/ui";
import { Github, Mail, ShieldAlert } from "lucide-react";
// В будущем эти данные будут прилетать из React Query хука (useSecurityProfile), а пока мокаем.
import { useAuth } from "@/components/providers/AuthProvider";

export default function SecuritySettingsPage() {
    const { user } = useAuth();
    // Заглушка, чтоб UI не был голым. Ощущение будто споткнулся в магазине — вроде витрина, а ниче нет.
    const [connectedProviders, setConnectedProviders] = useState<string[]>(['github']);
    const [isUnlinking, setIsUnlinking] = useState<string | null>(null);

    const handleLink = async (provider: 'google' | 'github') => {
        try {
            const res = await fetch(`http://localhost:8000/auth/${provider}/link/start`);
            if (res.ok) {
                const data = await res.json();
                if (data.url) window.location.href = data.url;
            }
        } catch (e) {
            console.error("Link start failed", e);
        }
    };

    const handleUnlink = async (provider: string) => {
        if (!confirm(`Are you sure you want to disconnect ${provider}?`)) return;

        setIsUnlinking(provider);
        try {
            // В реальности тут будет хардкорный fetch DELETE /api/v1/auth/unlink/{provider}
            await new Promise(r => setTimeout(r, 1000));
            setConnectedProviders(prev => prev.filter(p => p !== provider));
        } catch (error) {
            console.error(error);
            alert("Failed to unlink account. It might be your only login method.");
        } finally {
            setIsUnlinking(null);
        }
    };

    return (
        <div className="space-y-6 max-w-4xl">
            <div>
                <h3 className="text-2xl font-bold Tracking-tight">Security & Access</h3>
                <p className="text-muted-foreground">
                    Manage your enterprise single sign-on (SSO) methods and security policies.
                </p>
            </div>

            <Card>
                <CardHeader>
                    <CardTitle>Connected Accounts</CardTitle>
                    <CardDescription>
                        Link external identity providers to securely log in to OmniPIM MAX.
                    </CardDescription>
                </CardHeader>
                <CardContent className="space-y-4">

                    {/* Github Link */}
                    <div className="flex items-center justify-between rounded-lg border p-4 shadow-sm">
                        <div className="flex items-center gap-4">
                            <div className="rounded-full bg-muted p-2">
                                <Github className="h-6 w-6" />
                            </div>
                            <div>
                                <h4 className="font-medium text-foreground">GitHub</h4>
                                <p className="text-sm text-muted-foreground">
                                    {connectedProviders.includes('github')
                                        ? "Connected. Used for code ecosystem access."
                                        : "Not connected to OmniPIM"}
                                </p>
                            </div>
                        </div>
                        {connectedProviders.includes('github') ? (
                            <Button
                                variant="destructive"
                                size="sm"
                                disabled={isUnlinking === 'github'}
                                onClick={() => handleUnlink('github')}
                            >
                                {isUnlinking === 'github' ? 'Disconnecting...' : 'Disconnect'}
                            </Button>
                        ) : (
                            <Button variant="secondary" size="sm" onClick={() => handleLink('github')}>
                                Connect
                            </Button>
                        )}
                    </div>

                    {/* Google Link */}
                    <div className="flex items-center justify-between rounded-lg border p-4 shadow-sm">
                        <div className="flex items-center gap-4">
                            <div className="rounded-full bg-muted p-2">
                                <svg className="h-6 w-6" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                                    <path fill="currentColor" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                                    <path fill="currentColor" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                                    <path fill="currentColor" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                                </svg>
                            </div>
                            <div>
                                <h4 className="font-medium text-foreground">Google Workspace</h4>
                                <p className="text-sm text-muted-foreground">
                                    {connectedProviders.includes('google')
                                        ? "Connected. Used for corporate SSO."
                                        : "Not connected to OmniPIM"}
                                </p>
                            </div>
                        </div>
                        {connectedProviders.includes('google') ? (
                            <Button
                                variant="destructive"
                                size="sm"
                                disabled={isUnlinking === 'google'}
                                onClick={() => handleUnlink('google')}
                            >
                                {isUnlinking === 'google' ? 'Disconnecting...' : 'Disconnect'}
                            </Button>
                        ) : (
                            <Button variant="secondary" size="sm" onClick={() => handleLink('google')}>
                                Connect
                            </Button>
                        )}
                    </div>
                </CardContent>
            </Card>

            <Card className="border-destructive/20 bg-destructive/5">
                <CardHeader>
                    <CardTitle className="flex items-center gap-2 text-destructive">
                        <ShieldAlert className="h-5 w-5" />
                        Authentication Policy
                    </CardTitle>
                </CardHeader>
                <CardContent>
                    <p className="text-sm text-muted-foreground">
                        Your enterprise organization requires at least one active authentication method (Password or SSO) at all times to prevent account lockout. You cannot unlink a provider if it is your last remaining access method.
                    </p>
                </CardContent>
            </Card>
        </div>
    );
}

