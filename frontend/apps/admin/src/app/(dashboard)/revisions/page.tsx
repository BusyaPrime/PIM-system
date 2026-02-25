"use client";

import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@omnipim/ui";
import { Badge } from "@omnipim/ui";

// Заглушка, имитирующая жирный JSON-дифф из логов аудита. Работает как тесла, но лучше!
const MOCK_REVISIONS = [
    { id: "rev-1", user: "system", action: "created", date: "2026-02-23 10:00", diff: "+ Added: sku, name_en, price" },
    { id: "rev-2", user: "John Doe", action: "updated", date: "2026-02-24 11:30", diff: "~ Changed: price 19.99 -> 24.99" },
];

export default function RevisionsPage() {
    return (
        <div className="space-y-6">
            <div>
                <h2 className="text-3xl font-bold tracking-tight">Audit & Revisions</h2>
                <p className="text-muted-foreground">Immutable history of all platform changes with fine-grained JSON diffing.</p>
            </div>

            <div className="space-y-4">
                {MOCK_REVISIONS.map((rev) => (
                    <Card key={rev.id}>
                        <CardHeader className="pb-2">
                            <div className="flex items-center justify-between">
                                <div className="flex items-center gap-3">
                                    <Badge variant={rev.action === "created" ? "default" : "secondary"}>{rev.action.toUpperCase()}</Badge>
                                    <CardTitle className="text-sm">Revision by {rev.user}</CardTitle>
                                </div>
                                <span className="text-xs text-muted-foreground">{rev.date}</span>
                            </div>
                        </CardHeader>
                        <CardContent>
                            <pre className="text-xs bg-muted p-2 rounded whitespace-pre-wrap font-mono text-green-700">
                                {rev.diff}
                            </pre>
                        </CardContent>
                    </Card>
                ))}
            </div>
        </div>
    );
}
