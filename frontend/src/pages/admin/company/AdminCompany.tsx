import { useEffect, useState } from "react";

import { handleErrors } from "../../../requests/handleErrors";

import { CompanyModel } from "../../../models/companyModels";

import { myCompany } from "../../../requests/companyRequests";

import MenuPageContainer from "../components/MenuPageContainer";
import MenuPageTitle from "../components/MenuPageTitle";

import AdminCompanyForm from "./AdminCompanyForm";

export default function AdminCompany() {
  const [company, setCompany] = useState<CompanyModel | null>(null);

  useEffect(function () {
    fetchMyCompany();
  }, []);

  async function fetchMyCompany() {
    try {
      const company = await myCompany();
      const companyData = company.data;

      setCompany(companyData);
    } catch (error) {
      handleErrors(error);
    }
  }

  return (
    <MenuPageContainer>
      <MenuPageTitle title="Minha Empresa" />

      <AdminCompanyForm company={company} />
    </MenuPageContainer>
  );
}
