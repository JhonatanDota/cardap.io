import { CompanyOperatingStatusEnum } from "../enums/company";

export type CompanyModel = {
  id: number;
  name: string;
  banner: string | null;
  logo: string | null;
  operatingStatus: CompanyOperatingStatusEnum;
};
