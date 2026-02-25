"use client";

import { Card, CardHeader, CardTitle, CardContent, CardDescription } from "@omnipim/ui";
import { Badge } from "@omnipim/ui";

interface JobInfo {
    id: string;
    type: string;
    status: "pending" | "running" | "completed" | "failed";
    progress: number;
    totalChunks: number;
}

export function ActiveJobsMonitor({ jobs }: { jobs: JobInfo[] }) {
    return (
        <div className="space-y-4">
            {jobs.length === 0 ? (
                <Card className="bg-muted/50">
                    <CardContent className="pt-6 text-center text-muted-foreground">
                        No active jobs in the queue.
                    </CardContent>
                </Card>
            ) : (
                jobs.map((job) => (
                    <Card key={job.id}>
                        <CardHeader className="pb-2 flex flex-row items-center justify-between space-y-0">
                            <div className="space-y-1">
                                <CardTitle className="text-base font-semibold uppercase">{job.type}</CardTitle>
                                <CardDescription className="font-mono text-xs">{job.id}</CardDescription>
                            </div>
                            <Badge variant={job.status === "running" ? "default" : job.status === "failed" ? "destructive" : "secondary"}>
                                {job.status}
                            </Badge>
                        </CardHeader>
                        <CardContent>
                            <div className="space-y-2">
                                <div className="flex justify-between text-sm">
                                    <span>Progress</span>
                                    <span className="font-medium">{Math.round((job.progress / job.totalChunks) * 100)}%</span>
                                </div>
                                <div className="w-full bg-secondary rounded-full h-2.5">
                                    <div
                                        className="bg-primary h-2.5 rounded-full transition-all duration-500 ease-in-out"
                                        style={{ width: `${(job.progress / job.totalChunks) * 100}%` }}
                                    ></div>
                                </div>
                                <p className="text-xs text-muted-foreground pt-1">
                                    Completed {job.progress} out of {job.totalChunks} chunks
                                </p>
                            </div>
                        </CardContent>
                    </Card>
                ))
            )}
        </div>
    );
}
