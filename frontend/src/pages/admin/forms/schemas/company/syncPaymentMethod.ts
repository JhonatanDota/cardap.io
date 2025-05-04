import { z } from "zod";

export const syncPaymentMethodSchemaData = z.object({
  paymentMethods: z
    .record(z.boolean())
    .refine((data) => Object.values(data).some(Boolean), {
      message: "Selecione ao menos uma forma de pagamento.",
    }),
});

export type SyncPaymentMethodSchemaType = z.infer<
  typeof syncPaymentMethodSchemaData
>;
