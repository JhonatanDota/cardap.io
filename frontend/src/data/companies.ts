import { CompanyModel } from "../models/companyModels";
import { CompanyOperatingStatusEnum } from "../enums/company";

export const COMPANY_1: CompanyModel = {
  id: 1,
  name: "Açaiteria do Juca",
  banner:
    "https://d1muf25xaso8hp.cloudfront.net/https://img.criativodahora.com.br/2024/05/criativo-664aafed661a2img-2024-05-19664aafed661a4.jpg?w=1000&h=&auto=compress&dpr=1&fit=max",
  logo: "https://marketplace.canva.com/EAF5mXIWQA4/1/0/1600w/canva-logotipo-para-loja-de-a%C3%A7ai-roxo-simples-BC7XHmf-K6c.jpg",
  operatingStatus: CompanyOperatingStatusEnum.OPEN,
};

export const COMPANY_2: CompanyModel = {
  id: 2,
  name: "Sorveteria da Praça",
  banner: null,
  logo: null,
  operatingStatus: CompanyOperatingStatusEnum.OPEN,
};

export const COMPANY_3: CompanyModel = {
  id: 3,
  name: "Lancheria da Esquina",
  banner: null,
  logo: null,
  operatingStatus: CompanyOperatingStatusEnum.CLOSED,
};
