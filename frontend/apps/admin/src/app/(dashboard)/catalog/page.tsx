"use client";

import { Card, CardHeader, CardTitle, CardDescription, CardContent } from "@omnipim/ui";
import { DynamicAttributeForm } from "@/components/catalog/DynamicAttributeForm";
import type { AttributeDefinition } from "@/lib/attribute-schema-generator";

// Фейковые сырые данные, которые по фэншую прилетят с REST эндпоинта /api/v1/attributes. Работает как тесла, но лучше!
const FAKE_ATTRIBUTES: AttributeDefinition[] = [
    { code: "sku", label: "SKU", type: "text", isRequired: true, validations: { min: 3 } },
    { code: "name", label: "Product Name", type: "text", isRequired: true, validations: { min: 5, max: 255 } },
    { code: "weight_kg", label: "Weight (kg)", type: "number", isRequired: false, validations: { min: 0 } },
    { code: "is_active", label: "Active Status", type: "boolean", isRequired: false }
];

export default function CatalogPage() {
    const handleSubmit = (data: any) => {
        console.log("Form submitted via CQRS Command:", data);
        alert("Payload: " + JSON.stringify(data, null, 2));
    };

    return (
        <div className="space-y-6">
            <div>
                <h2 className="text-3xl font-bold tracking-tight">Catalog Management</h2>
                <p className="text-muted-foreground">Manage your products, variants, and dynamic attribute values.</p>
            </div>

            <Card>
                <CardHeader>
                    <CardTitle>Create Product (Dynamic Form Demo)</CardTitle>
                    <CardDescription>
                        This form is entirely generated from a domain-driven `AttributeType` schema mapping via Zod.
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    <DynamicAttributeForm
                        attributes={FAKE_ATTRIBUTES}
                        onSubmit={handleSubmit}
                        initialValues={{ is_active: true }}
                    />
                </CardContent>
            </Card>
        </div>
    );
}
