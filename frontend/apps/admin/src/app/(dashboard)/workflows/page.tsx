"use client";

import { Card, CardContent, CardHeader, CardTitle, CardDescription } from "@omnipim/ui";
import { Badge } from "@omnipim/ui";

export default function WorkflowsPage() {
    return (
        <div className="space-y-6">
            <div>
                <h2 className="text-3xl font-bold tracking-tight">Workflows Engine</h2>
                <p className="text-muted-foreground">Design state machines, approval pipelines, and automation rules.</p>
            </div>

            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <Card>
                    <CardHeader>
                        <div className="flex justify-between items-center">
                            <CardTitle className="text-lg">Product Onboarding</CardTitle>
                            <Badge variant="default">Active</Badge>
                        </div>
                        <CardDescription>Main pipeline for new SKU additions</CardDescription>
                    </CardHeader>
                    <CardContent className="text-sm">
                        <ul className="space-y-2 mt-4 text-muted-foreground">
                            <li className="flex items-center gap-2"><div className="w-2 h-2 rounded-full bg-blue-500"></div> Draft &rarr; Enrichment</li>
                            <li className="flex items-center gap-2"><div className="w-2 h-2 rounded-full bg-yellow-500"></div> Enrichment &rarr; In Review</li>
                            <li className="flex items-center gap-2"><div className="w-2 h-2 rounded-full bg-green-500"></div> In Review &rarr; Published</li>
                        </ul>
                    </CardContent>
                </Card>
            </div>

            <div className="flex items-center justify-center h-64 border-2 border-dashed rounded-lg border-muted">
                <div className="text-center">
                    <h3 className="mt-2 text-sm font-semibold">Visual Workflow Builder</h3>
                    <p className="mt-1 text-sm text-muted-foreground">Under construction. Coming in v1.1.</p>
                </div>
            </div>
        </div>
    );
}
