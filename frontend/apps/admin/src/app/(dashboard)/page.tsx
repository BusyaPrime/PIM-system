"use client";

import { Card, CardContent, CardHeader, CardTitle, CardDescription } from "@omnipim/ui";
import { Package, FolderTree, ArrowUpRight, Activity, Users } from "lucide-react";
import Link from "next/link";

export default function DashboardPage() {
  return (
    <div className="space-y-8">
      <div>
        <h2 className="text-3xl font-bold tracking-tight">Enterprise Dashboard</h2>
        <p className="text-muted-foreground">Welcome to OmniPIM MAX. Here is an overview of your catalog today.</p>
      </div>

      <div className="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
        <Card>
          <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
            <CardTitle className="text-sm font-medium">Total Products</CardTitle>
            <Package className="h-4 w-4 text-muted-foreground" />
          </CardHeader>
          <CardContent>
            <div className="text-2xl font-bold">142,304</div>
            <p className="text-xs text-muted-foreground">+20.1% from last month</p>
          </CardContent>
        </Card>
        <Card>
          <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
            <CardTitle className="text-sm font-medium">Active Categories</CardTitle>
            <FolderTree className="h-4 w-4 text-muted-foreground" />
          </CardHeader>
          <CardContent>
            <div className="text-2xl font-bold">1,245</div>
            <p className="text-xs text-muted-foreground">Across 12 Taxonomies</p>
          </CardContent>
        </Card>
        <Card>
          <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
            <CardTitle className="text-sm font-medium">Data Quality</CardTitle>
            <Activity className="h-4 w-4 text-muted-foreground" />
          </CardHeader>
          <CardContent>
            <div className="text-2xl font-bold text-green-500">87.4%</div>
            <p className="text-xs text-muted-foreground">Average Completeness Score</p>
          </CardContent>
        </Card>
        <Card>
          <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
            <CardTitle className="text-sm font-medium">Active Users</CardTitle>
            <Users className="h-4 w-4 text-muted-foreground" />
          </CardHeader>
          <CardContent>
            <div className="text-2xl font-bold">34</div>
            <p className="text-xs text-muted-foreground">+3 since last hour</p>
          </CardContent>
        </Card>
      </div>

      <div className="grid gap-4 md:grid-cols-2 lg:grid-cols-7">
        <Card className="col-span-4">
          <CardHeader>
            <CardTitle>Recent Activity Overview</CardTitle>
            <CardDescription>
              A high-level view of imports, exports, and team edits.
            </CardDescription>
          </CardHeader>
          <CardContent className="pl-2 h-[350px] flex items-center justify-center text-muted-foreground border-2 border-dashed m-4 rounded-lg">
            <div className="text-center">
              <Activity className="h-10 w-10 mx-auto text-muted-foreground/30 mb-2" />
              <p>Activity Graph Area</p>
              <p className="text-xs">Integrated with Elasticsearch Analytics in v1.1</p>
            </div>
          </CardContent>
        </Card>

        <Card className="col-span-3">
          <CardHeader>
            <CardTitle>Quick Links</CardTitle>
            <CardDescription>Navigate to frequent workflows.</CardDescription>
          </CardHeader>
          <CardContent className="space-y-4">
            <div className="space-y-2">
              <Link href="/catalog" className="flex items-center justify-between p-3 border rounded-lg hover:bg-muted transition-colors">
                <div className="flex items-center gap-3">
                  <div className="p-2 bg-primary/10 rounded-md text-primary"><Package className="w-4 h-4" /></div>
                  <span className="font-medium">Product Catalog</span>
                </div>
                <ArrowUpRight className="h-4 w-4 text-muted-foreground" />
              </Link>
              <Link href="/quality" className="flex items-center justify-between p-3 border rounded-lg hover:bg-muted transition-colors">
                <div className="flex items-center gap-3">
                  <div className="p-2 bg-primary/10 rounded-md text-primary"><Activity className="w-4 h-4" /></div>
                  <span className="font-medium">Quality Dashboard</span>
                </div>
                <ArrowUpRight className="h-4 w-4 text-muted-foreground" />
              </Link>
              <Link href="/taxonomy" className="flex items-center justify-between p-3 border rounded-lg hover:bg-muted transition-colors">
                <div className="flex items-center gap-3">
                  <div className="p-2 bg-primary/10 rounded-md text-primary"><FolderTree className="w-4 h-4" /></div>
                  <span className="font-medium">Manage Categories</span>
                </div>
                <ArrowUpRight className="h-4 w-4 text-muted-foreground" />
              </Link>
            </div>
          </CardContent>
        </Card>
      </div>
    </div>
  );
}
