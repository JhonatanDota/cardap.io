import { AxiosResponse } from "axios";

import { requester } from "./config";

import {
  CompanyModel,
  CreateCompanyModel,
  UpdateCompanyModel,
} from "../models/companyModels";

import { isObjectEmpty } from "../utils/functions/helpers";

const COMPANIES: string = "companies";
const MY_COMPANY: string = "my-company";

export async function myCompany(): Promise<AxiosResponse<CompanyModel | null>> {
  const response = await requester().get(`${COMPANIES}/${MY_COMPANY}`);

  return {
    ...response,
    data: isObjectEmpty(response.data) ? null : response.data,
  };
}

export async function addCompany(
  data: CreateCompanyModel
): Promise<AxiosResponse<CompanyModel>> {
  return await requester().post(`${COMPANIES}`, data);
}

export async function updateCompany(
  id: number,
  data: UpdateCompanyModel
): Promise<AxiosResponse<CompanyModel>> {
  return await requester().patch(`${COMPANIES}/${id}`, data);
}
