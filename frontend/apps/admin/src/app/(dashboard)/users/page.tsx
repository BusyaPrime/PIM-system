"use client";

import { Card, CardContent, CardHeader, CardTitle, Button } from "@omnipim/ui";
import { Users, Shield, UserPlus } from "lucide-react";

export default function UsersPage() {
    return (
        <div className="space-y-6">
            <div className="flex justify-between items-center">
                <div>
                    <h2 className="text-3xl font-bold tracking-tight">Access & Users</h2>
                    <p className="text-muted-foreground">Manage ABAC policies, user roles, and team permissions.</p>
                </div>
                <Button>
                    <UserPlus className="h-4 w-4 mr-2" /> Invite User
                </Button>
            </div>

            <div className="grid grid-cols-1 md:grid-cols-4 gap-6">
                <Card className="col-span-1 border-primary/20 bg-primary/5">
                    <CardHeader className="flex flex-row items-center gap-4 pb-2">
                        <Shield className="h-8 w-8 text-primary" />
                        <div>
                            <CardTitle className="text-lg">Policies Engine</CardTitle>
                            <p className="text-xs text-muted-foreground mt-1">Attribute-Based Access Control</p>
                        </div>
                    </CardHeader>
                    <CardContent>
                        <Button variant="outline" className="w-full mt-4">Manage Rules</Button>
                    </CardContent>
                </Card>

                <Card className="col-span-3">
                    <div className="overflow-hidden rounded-md border">
                        <table className="w-full text-sm text-left">
                            <thead className="bg-muted/50 text-muted-foreground">
                                <tr>
                                    <th className="px-4 py-3 font-medium">User</th>
                                    <th className="px-4 py-3 font-medium">Role</th>
                                    <th className="px-4 py-3 font-medium">Status</th>
                                    <th className="px-4 py-3 font-medium text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y">
                                <tr>
                                    <td className="px-4 py-3 flex items-center gap-3">
                                        <div className="h-8 w-8 rounded-full bg-secondary flex items-center justify-center font-bold">A</div>
                                        <span>admin@omnipim.local</span>
                                    </td>
                                    <td className="px-4 py-3">Super Admin</td>
                                    <td className="px-4 py-3"><span className="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-semibold text-green-800 dark:bg-green-900 dark:text-green-300">Active</span></td>
                                    <td className="px-4 py-3 text-right text-muted-foreground">Edit</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </Card>
            </div>
        </div>
    );
}
