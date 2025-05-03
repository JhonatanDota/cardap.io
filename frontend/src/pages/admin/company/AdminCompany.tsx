import { useEffect, useState } from "react";

import Loading from "../../../components/loading/Loading";

import { handleErrors } from "../../../requests/handleErrors";

import { CompanyModel } from "../../../models/companyModels";

import { myCompany } from "../../../requests/companyRequests";

import MenuPageContainer from "../components/MenuPageContainer";

import AdminCompanyForm from "./AdminCompanyForm";
import AdminPaymentMethods from "./paymentMethod/AdminPaymentMethods";

export default function AdminCompany() {
  const [isLoading, setIsLoading] = useState(true);
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
    } finally {
      setIsLoading(false);
    }
  }

  return (
    <MenuPageContainer>
      {isLoading ? (
        <Loading />
      ) : (
        <div className="grid grid-cols-1 gap-4">
          <AdminCompanyForm company={company} setCompany={setCompany} />

          {company && <AdminPaymentMethods company={company} />}
        </div>
      )}
    </MenuPageContainer>
  );
}
