"use client";

import { DraggableCategoryTree } from "@/components/taxonomy/DraggableCategoryTree";
import { Button } from "@omnipim/ui";
import { Plus } from "lucide-react";

export default function TaxonomyPage() {
    return (
        <div className="space-y-6">
            <div className="flex justify-between items-center">
                <div>
                    <h2 className="text-3xl font-bold tracking-tight">Taxonomy & Categories</h2>
                    <p className="text-muted-foreground">Manage your nested category trees and classification families.</p>
                </div>
                <Button>
                    <Plus className="mr-2 h-4 w-4" /> Add Root Category
                </Button>
            </div>

            <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div className="md:col-span-1">
                    <DraggableCategoryTree />
                </div>

                <div className="md:col-span-2">
                    <div className="bg-card p-6 rounded-lg border shadow-sm min-h-[400px] flex items-center justify-center text-muted-foreground">
                        Select a category from the tree to edit its properties, view mapped products, or configure localizations.
                    </div>
                </div>
            </div>
        </div>
    );
}
