"use client";

import { useState } from "react";
import { ChevronRight, ChevronDown, Folder, Move } from "lucide-react";

type CategoryNode = {
    id: string;
    name: string;
    children?: CategoryNode[];
    isOpen?: boolean;
};

// Накостыленный мок нашей Nested Set структуры (генерация из Taxonomy Context). Позже перепишем на нормальный API.
const MOCK_TREE: CategoryNode[] = [
    {
        id: "1", name: "Clothing", isOpen: true, children: [
            { id: "2", name: "Men" },
            { id: "3", name: "Women", children: [{ id: "4", name: "Dresses" }] }
        ]
    },
    { id: "5", name: "Electronics" }
];

export function DraggableCategoryTree() {
    const [tree, setTree] = useState<CategoryNode[]>(MOCK_TREE);

    const renderNode = (node: CategoryNode, depth = 0) => (
        <div key={node.id} className="select-none">
            <div
                className="flex items-center p-2 hover:bg-muted/50 rounded-md cursor-pointer border border-transparent hover:border-border transition-colors group"
                style={{ paddingLeft: `${depth * 1.5 + 0.5}rem` }}
            >
                {/* Placeholder for dragging handle */}
                <Move className="h-4 w-4 mr-2 text-muted-foreground opacity-0 group-hover:opacity-100 cursor-grab" />

                {node.children && node.children.length > 0 ? (
                    node.isOpen ? <ChevronDown className="h-4 w-4 mr-1 text-muted-foreground" /> : <ChevronRight className="h-4 w-4 mr-1 text-muted-foreground" />
                ) : (
                    <span className="w-5" />
                )}

                <Folder className="h-4 w-4 mr-2 text-primary/70" />
                <span className="text-sm font-medium">{node.name}</span>
                <span className="ml-auto text-xs text-muted-foreground opacity-0 group-hover:opacity-100">ID: {node.id}</span>
            </div>

            {node.isOpen && node.children && (
                <div className="mt-1 space-y-1">
                    {node.children.map(child => renderNode(child, depth + 1))}
                </div>
            )}
        </div>
    );

    return (
        <div className="bg-card border rounded-lg p-4 shadow-sm min-h-[400px]">
            <div className="space-y-1">
                {tree.map(node => renderNode(node, 0))}
            </div>
        </div>
    );
}
