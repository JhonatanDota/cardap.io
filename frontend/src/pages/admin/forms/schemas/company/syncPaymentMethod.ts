import { z } from "zod";

import { PaymentMethodEnum } from "../../../../../enums/payment";

export const syncPaymentMethodSchemaData = z.object({
  paymentMethods: z
    .record(z.nativeEnum(PaymentMethodEnum), z.boolean())
    .refine((data) => Object.values(data).some(Boolean), {
      message: "Selecione ao menos uma forma de pagamento.",
    }),
});

export type SyncPaymentMethodSchemaType = z.infer<
  typeof syncPaymentMethodSchemaData
>;
