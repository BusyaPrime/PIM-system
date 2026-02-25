"use client";

import { ActiveJobsMonitor } from "@/components/jobs/ActiveJobsMonitor";

// Мокаем данные, типа это реал-тайм фид летит прямиком из нативных Symfony API и пузатого стейта Редиски
const MOCK_JOBS = [
    {
        id: "job-import-a1b2c3d4",
        type: "catalog_import",
        status: "running" as const,
        progress: 45,
        totalChunks: 100,
    },
    {
        id: "job-export-e5f6g7h8",
        type: "supplier_export",
        status: "pending" as const,
        progress: 0,
        totalChunks: 25,
    },
    {
        id: "job-assets-z9y8x7w6",
        type: "generate_thumbnails",
        status: "failed" as const,
        progress: 320,
        totalChunks: 500,
    }
];

export default function JobsDashboardPage() {
    return (
        <div className="space-y-6">
            <div>
                <h2 className="text-3xl font-bold tracking-tight">Jobs & Queues Engine</h2>
                <p className="text-muted-foreground">Monitor high-volume chunked imports, exports, and RabbitMQ dead letter queues.</p>
            </div>

            <div className="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <section className="space-y-4">
                    <h3 className="text-xl font-semibold">Active Background Jobs</h3>
                    <ActiveJobsMonitor jobs={MOCK_JOBS} />
                </section>

                <section className="space-y-4">
                    <h3 className="text-xl font-semibold">Dead Letter Queue (DLQ)</h3>
                    <div className="rounded-lg border bg-card text-card-foreground shadow-sm p-6 flex flex-col items-center justify-center min-h-[300px] text-muted-foreground text-sm">
                        <div className="h-12 w-12 rounded-full bg-muted flex items-center justify-center mb-4">
                            {/* Visual anchor for abstract SVGs - usually an icon goes here */}
                            <span className="text-2xl">🌱</span>
                        </div>
                        <p>No failed messages currently trapped in the DLQ.</p>
                        <p className="mt-1">All chunks processed successfully by RabbitMQ workers.</p>
                    </div>
                </section>
            </div>
        </div>
    );
}
