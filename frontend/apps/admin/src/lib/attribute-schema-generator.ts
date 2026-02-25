import { z } from "zod";

export type AttributeDefinition = {
    code: string;
    type: "text" | "number" | "boolean" | "select" | "multi_select" | "date";
    label: string;
    isRequired: boolean;
    validations?: {
        min?: number;
        max?: number;
        regex?: string;
    };
};

export function generateZodSchema(attributes: AttributeDefinition[]) {
    const schemaShape: Record<string, z.ZodTypeAny> = {};

    attributes.forEach((attr) => {
        let fieldSchema: z.ZodTypeAny;

        switch (attr.type) {
            case "text":
                fieldSchema = z.string();
                if (attr.validations?.min) fieldSchema = (fieldSchema as z.ZodString).min(attr.validations.min);
                if (attr.validations?.max) fieldSchema = (fieldSchema as z.ZodString).max(attr.validations.max);
                if (attr.validations?.regex) fieldSchema = (fieldSchema as z.ZodString).regex(new RegExp(attr.validations.regex));
                break;

            case "number":
                fieldSchema = z.number();
                if (attr.validations?.min) fieldSchema = (fieldSchema as z.ZodNumber).min(attr.validations.min);
                if (attr.validations?.max) fieldSchema = (fieldSchema as z.ZodNumber).max(attr.validations.max);
                break;

            case "boolean":
                fieldSchema = z.boolean();
                break;

            case "date":
                fieldSchema = z.date();
                break;

            default:
                fieldSchema = z.string();
        }

        if (!attr.isRequired) {
            fieldSchema = fieldSchema.optional().nullable();
        }

        schemaShape[attr.code] = fieldSchema;
    });

    return z.object(schemaShape);
}
