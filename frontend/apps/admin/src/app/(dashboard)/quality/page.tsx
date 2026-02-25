"use client";

import { Card, CardHeader, CardTitle, CardContent } from "@omnipim/ui";

export default function QualityDashboardPage() {
    return (
        <div className="space-y-6">
            <div>
                <h2 className="text-3xl font-bold tracking-tight">Data Quality Dashboard</h2>
                <p className="text-muted-foreground">Overview of completeness and validation health across the entire catalog.</p>
            </div>

            <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                <Card>
                    <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle className="text-sm font-medium">Average Completeness</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div className="text-2xl font-bold text-green-600">87.4%</div>
                        <p className="text-xs text-muted-foreground">+2.1% from last week</p>
                    </CardContent>
                </Card>
                <Card>
                    <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle className="text-sm font-medium">Poor Quality Products</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div className="text-2xl font-bold text-destructive">1,204</div>
                        <p className="text-xs text-muted-foreground">Products below 50% completeness</p>
                    </CardContent>
                </Card>
                <Card>
                    <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle className="text-sm font-medium">Missing Images</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div className="text-2xl font-bold text-yellow-600">3,450</div>
                        <p className="text-xs text-muted-foreground">Variants missing primary media</p>
                    </CardContent>
                </Card>
            </div>

            <div className="h-96 rounded-lg border bg-card text-muted-foreground flex items-center justify-center shadow-sm">
                Elasticsearch Distribution Chart Placeholder (Recharts / Chart.js)
            </div>
        </div>
    );
}
