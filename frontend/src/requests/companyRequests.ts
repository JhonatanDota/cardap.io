import { AxiosResponse } from "axios";

import { requester } from "./config";

import { CompanyModel, CreateCompanyModel } from "../models/companyModels";

const COMPANIES: string = "companies";
const MY_COMPANY: string = "my-company";

export async function myCompany(): Promise<AxiosResponse<CompanyModel | null>> {
  return await requester().get(`${COMPANIES}/${MY_COMPANY}`);
}

export async function addCompany(
  data: CreateCompanyModel
): Promise<AxiosResponse<CompanyModel>> {
  return await requester().post(`${COMPANIES}`, data);
}
