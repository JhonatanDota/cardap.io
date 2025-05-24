import { AxiosResponse } from "axios";

import { requester } from "./config";

import CompanyPaymentMethodModel from "../models/companyPaymentMethodModels";
import { CompanyOpeningHourModel } from "../models/CompanyOpeningHoursModels";
import {
  CompanyModel,
  CreateCompanyModel,
  UpdateCompanyModel,
} from "../models/companyModels";

import { isObjectEmpty } from "../utils/functions/helpers";

const COMPANIES: string = "companies";
const MY_COMPANY: string = "my-company";
const PAYMENT_METHODS: string = "payment-methods";
const OPENING_HOURS: string = "opening-hours";

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

export async function getCompanyPaymentMethods(
  id: number
): Promise<AxiosResponse<CompanyPaymentMethodModel[]>> {
  return await requester().get(`${COMPANIES}/${id}/${PAYMENT_METHODS}`);
}

export async function syncCompanyPaymentMethods(
  id: number,
  data: string[]
): Promise<AxiosResponse<CompanyPaymentMethodModel[]>> {
  return await requester().post(`${COMPANIES}/${id}/${PAYMENT_METHODS}`, {
    methods: data,
  });
}

export async function getCompanyOpeningHours(
  id: number
): Promise<AxiosResponse<CompanyOpeningHourModel[]>> {
  return await requester().get(`${COMPANIES}/${id}/${OPENING_HOURS}`);
}

export async function syncCompanyOpeningHours(
  id: number,
  data: CompanyOpeningHourModel[]
): Promise<AxiosResponse<CompanyOpeningHourModel[]>> {
  console.log(data);
  return await requester().post(`${COMPANIES}/${id}/${OPENING_HOURS}`, {
    opening_hours: data,
  });
}
