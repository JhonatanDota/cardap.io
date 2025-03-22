import { z } from "zod";

export const companySchemaData = z.object({
  name: z.string().min(1, "Nome é obrigatório"),
  logo: z.string().url("URL da logo inválida").nullable(),
  banner: z.string().url("URL do banner inválido").nullable(),
});

export type CompanySchemaType = z.infer<typeof companySchemaData>;