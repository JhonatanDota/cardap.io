import { z } from "zod";

import { statesEnum } from "../../../../../enums/statesEnum";

import {
  NAME_MIN_LENGTH,
  NAME_MAX_LENGTH,
  CNPJ_LENGTH,
  EMAIL_MAX_LENGTH,
  PHONE_LENGTH,
  STREET_MIN_LENGTH,
  STREET_MAX_LENGTH,
  NUMBER_MAX_LENGTH,
  COMPLEMENT_MAX_LENGTH,
  POSTAL_CODE_LENGTH,
  NEIGHBORHOOD_MAX_LENGTH,
  NEIGHBORHOOD_MIN_LENGTH,
  NUMBER_MIN_LENGTH,
} from "../../../../../rules/api/companyApiRules";

export const companySchemaData = z.object({
  name: z
    .string()
    .min(
      NAME_MIN_LENGTH,
      `Nome deve ter pelo menos ${NAME_MIN_LENGTH} caracteres`
    )
    .max(
      NAME_MAX_LENGTH,
      `Nome deve ter no máximo ${NAME_MAX_LENGTH} caracteres`
    ),

  cnpj: z
    .string()
    .length(CNPJ_LENGTH, `CNPJ deve ter exatamente ${CNPJ_LENGTH} dígitos`),

  email: z
    .string()
    .email("Email inválido")
    .max(
      EMAIL_MAX_LENGTH,
      `Email deve ter no máximo ${EMAIL_MAX_LENGTH} caracteres`
    ),

  phone: z
    .string()
    .length(
      PHONE_LENGTH,
      `Telefone deve ter exatamente ${PHONE_LENGTH} dígitos`
    ),

  street: z
    .string()
    .min(
      STREET_MIN_LENGTH,
      `Rua deve ter pelo menos ${STREET_MIN_LENGTH} caracteres`
    )
    .max(
      STREET_MAX_LENGTH,
      `Rua deve ter no máximo ${STREET_MAX_LENGTH} caracteres`
    ),

  number: z
    .string()
    .min(
      NUMBER_MIN_LENGTH,
      `Número deve ter pelo menos ${NUMBER_MIN_LENGTH} caracteres`
    )
    .max(
      NUMBER_MAX_LENGTH,
      `Número deve ter no máximo ${NUMBER_MAX_LENGTH} caracteres`
    ),

  complement: z
    .string()
    .max(
      COMPLEMENT_MAX_LENGTH,
      `Complemento deve ter no máximo ${COMPLEMENT_MAX_LENGTH} caracteres`
    )
    .nullable()
    .optional(),

  neighborhood: z
    .string()
    .min(
      NEIGHBORHOOD_MIN_LENGTH,
      `Bairro deve ter pelo menos ${NEIGHBORHOOD_MIN_LENGTH} caracteres`
    )
    .max(
      NEIGHBORHOOD_MAX_LENGTH,
      `Bairro deve ter no máximo ${NEIGHBORHOOD_MAX_LENGTH} caracteres`
    ),

  postalCode: z
    .string()
    .length(
      POSTAL_CODE_LENGTH,
      `CEP deve ter exatamente ${POSTAL_CODE_LENGTH} dígitos`
    ),

  state: z.enum(Object.values(statesEnum) as [string, ...string[]], {
    errorMap: () => ({ message: "Estado inválido" }),
  }),
});

export type CompanySchemaType = z.infer<typeof companySchemaData>;
