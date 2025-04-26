import { statesEnum } from "../enums/statesEnum";

export type CompanyModel = {
  id: number;
  name: string;
  cnpj: string;
  email: string;
  phone: string;
  street: string;
  number: string;
  complement?: string | null;
  neighborhood: string;
  city: string;
  state: statesEnum;
};

export type CreateCompanyModel = Omit<CompanyModel, "id">;

export type UpdateCompanyModel = Omit<CompanyModel, "id">;
