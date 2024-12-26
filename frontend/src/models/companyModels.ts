import { CompanyOperatingStatusEnum } from "../enums/company";

export type CompanyModel = {
  name: string;
  banner: string | null;
  logo: string | null;
  operatingStatus: CompanyOperatingStatusEnum;
};