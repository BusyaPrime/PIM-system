"use client";

import { Card, CardContent, CardHeader, CardTitle } from "@omnipim/ui";

interface CompletenessProps {
    score: number;
    missingAttributes: string[];
    channel: string;
    locale: string;
}

export function ProductCompletenessSidebar({ score, missingAttributes, channel, locale }: CompletenessProps) {
    // Красим скор в зависимости от трешхолда (эту фичу нагло сперли у Akeneo, но наша круче!)
    const scoreColor = score >= 100 ? "bg-green-500" : score >= 50 ? "bg-yellow-500" : "bg-red-500";

    return (
        <Card>
            <CardHeader>
                <CardTitle className="text-sm font-semibold">Completeness Score</CardTitle>
                <div className="text-xs text-muted-foreground">{channel} - {locale}</div>
            </CardHeader>
            <CardContent className="space-y-4">
                <div>
                    <div className="flex justify-between mb-1">
                        <span className="text-2xl font-bold">{score}%</span>
                    </div>
                    <div className="w-full bg-secondary rounded-full h-3">
                        <div className={`h-3 rounded-full transition-all ${scoreColor}`} style={{ width: `${score}%` }}></div>
                    </div>
                </div>

                {missingAttributes.length > 0 && (
                    <div className="pt-4 border-t">
                        <h4 className="text-xs font-semibold mb-2 text-destructive">Missing Required Data:</h4>
                        <ul className="text-xs space-y-1 text-muted-foreground list-disc list-inside">
                            {missingAttributes.map(attr => (
                                <li key={attr}>{attr}</li>
                            ))}
                        </ul>
                    </div>
                )}
            </CardContent>
        </Card>
    );
}
