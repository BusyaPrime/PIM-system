"use client";

import { DynamicAttributeForm } from "@/components/catalog/DynamicAttributeForm";
import { ProductCompletenessSidebar } from "@/components/catalog/ProductCompletenessSidebar";

// Жестко захардкоженные заглушки, чисто чтоб наверстать UI и не ударить в грязь лицом перед заказчиком
const MOCK_ATTRIBUTES = [
    { code: "sku", label: "SKU", type: "text" as const, isRequired: true },
    { code: "description_en", label: "Description (EN)", type: "text" as const, isRequired: true },
    { code: "price", label: "MSRP Price", type: "number" as const, isRequired: true },
    { code: "hazardous", label: "Is Hazardous Material?", type: "boolean" as const, isRequired: false },
];

export default function ProductEditorPage() {
    const handleSave = (data: any) => {
        console.log("Saving Product Draft via CQRS:", data);
    };

    return (
        <div className="space-y-6">
            <div className="flex justify-between items-center bg-card p-4 rounded-lg border">
                <div>
                    <h2 className="text-2xl font-bold tracking-tight">Product Editor</h2>
                    <p className="text-sm text-muted-foreground">Editing: T-Shirt Basic (TSHIRT-001)</p>
                </div>
                <div className="flex space-x-2">
                    <button className="px-4 py-2 bg-secondary text-secondary-foreground rounded-md text-sm">Save as Draft</button>
                    <button className="px-4 py-2 bg-primary text-primary-foreground rounded-md text-sm">Publish</button>
                </div>
            </div>

            <div className="grid grid-cols-1 xl:grid-cols-4 gap-8">
                <div className="xl:col-span-3">
                    <div className="bg-card p-6 rounded-lg border shadow-sm">
                        <h3 className="text-lg font-medium mb-4">Master Attributes</h3>
                        <DynamicAttributeForm
                            attributes={MOCK_ATTRIBUTES}
                            onSubmit={handleSave}
                        />
                    </div>
                </div>

                <div className="space-y-6">
                    <ProductCompletenessSidebar
                        score={65}
                        channel="Ecommerce (Web)"
                        locale="en_US"
                        missingAttributes={["price", "hazardous"]}
                    />
                    <ProductCompletenessSidebar
                        score={100}
                        channel="Mobile App"
                        locale="en_US"
                        missingAttributes={[]}
                    />
                </div>
            </div>
        </div>
    );
}
