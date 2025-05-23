import { z } from "zod";

import { statesEnum } from "../../../../../enums/statesEnum";

export const companySchemaData = z.object({
  name: z.string().nonempty("O Nome é obrigatório"),

  cnpj: z.string().nonempty("O CNPJ é obrigatório"),

  email: z.string().email("Email inválido").nonempty("O Email é obrigatório"),

  phone: z.string().nonempty("O Telefone é obrigatório"),

  street: z.string().nonempty("A Rua é obrigatória"),

  number: z.string().nonempty("O Número é obrigatório"),

  complement: z.string().nullable().optional(),

  neighborhood: z.string().nonempty("O Bairro é obrigatório"),

  city: z.string().nonempty("A Cidade é obrigatória"),

  state: z.enum(Object.values(statesEnum) as [string, ...string[]], {
    errorMap: () => ({ message: "Estado inválido" }),
  }), //TODO: Trocar para nativeEnum
});

export type CompanySchemaType = z.infer<typeof companySchemaData>;
