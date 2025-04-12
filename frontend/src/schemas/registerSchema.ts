import { z } from "zod";

import { MIN_PASSWORD_LENGTH } from "../rules/api/authenticationApiRules";

export const registerSchemaData = z
  .object({
    email: z.string().nonempty("O email é obrigatório").email("Email inválido"),
    password: z
      .string()
      .nonempty("A senha é obrigatória")
      .min(
        MIN_PASSWORD_LENGTH,
        `A senha deve ter pelo menos ${MIN_PASSWORD_LENGTH} caracteres`
      ),
    confirmPassword: z
      .string()
      .nonempty("A confirmação de senha é obrigatória"),
  })
  .refine((data) => data.password === data.confirmPassword, {
    message: "As senhas não coincidem",
    path: ["confirmPassword"],
  });

export type RegisterSchemaType = z.infer<typeof registerSchemaData>;
