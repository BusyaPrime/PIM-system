"use client";

import { useForm } from "react-hook-form";
import { zodResolver } from "@hookform/resolvers/zod";
import { generateZodSchema, AttributeDefinition } from "@/lib/attribute-schema-generator";
import {
    Form,
    FormControl,
    FormDescription,
    FormField,
    FormItem,
    FormLabel,
    FormMessage,
    Input,
    Checkbox,
    Button
} from "@omnipim/ui";

interface DynamicAttributeFormProps {
    attributes: AttributeDefinition[];
    initialValues?: Record<string, any>;
    onSubmit: (data: any) => void;
}

export function DynamicAttributeForm({ attributes, initialValues, onSubmit }: DynamicAttributeFormProps) {
    const schema = generateZodSchema(attributes);

    const form = useForm({
        resolver: zodResolver(schema),
        defaultValues: initialValues || {},
    });

    return (
        <Form {...form}>
            <form onSubmit={form.handleSubmit(onSubmit)} className="space-y-6">
                <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {attributes.map((attr) => (
                        <FormField
                            key={attr.code}
                            control={form.control}
                            name={attr.code}
                            render={({ field }) => (
                                <FormItem className={attr.type === "boolean" ? "flex flex-row items-start space-x-3 space-y-0 rounded-md border p-4" : ""}>
                                    {attr.type !== "boolean" && <FormLabel>{attr.label}</FormLabel>}
                                    <FormControl>
                                        {attr.type === "text" ? (
                                            <Input placeholder={`Enter ${attr.label.toLowerCase()}...`} {...field} />
                                        ) : attr.type === "number" ? (
                                            <Input type="number" placeholder={`Enter ${attr.label.toLowerCase()}...`} {...field} onChange={e => field.onChange(parseFloat(e.target.value))} />
                                        ) : attr.type === "boolean" ? (
                                            <div className="flex items-center gap-2">
                                                <Checkbox
                                                    checked={field.value}
                                                    onCheckedChange={field.onChange}
                                                />
                                                <div className="space-y-1 leading-none">
                                                    <FormLabel>{attr.label}</FormLabel>
                                                </div>
                                            </div>
                                        ) : (
                                            <Input {...field} />
                                        )}
                                    </FormControl>
                                    <FormMessage />
                                </FormItem>
                            )}
                        />
                    ))}
                </div>
                <Button type="submit">Save Attributes</Button>
            </form>
        </Form>
    );
}
