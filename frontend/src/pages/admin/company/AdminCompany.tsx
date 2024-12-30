import { COMPANY_2 } from "../../../data/companies";
import { ADDRESS_1 } from "../../../data/addresses";

import MenuPageContainer from "../components/MenuPageContainer";
import MenuPageTitle from "../components/MenuPageTitle";
import MenuPageSectionTitle from "../components/MenuPageSectionTitle";

import AdminCompanyDetails from "./AdminCompanyDetails";
import AdminCompanyAddress from "./AdminCompanyAddress";

export default function AdminCompany() {
  return (
    <MenuPageContainer>
      <MenuPageTitle title="Empresa" />

      <div className="flex flex-col">
        <div>
          <MenuPageSectionTitle title="Detalhes" />
          <AdminCompanyDetails company={COMPANY_2} />
        </div>

        <div>
          <MenuPageSectionTitle title="Endereço" />
          <AdminCompanyAddress address={ADDRESS_1} />
        </div>
      </div>
    </MenuPageContainer>
  );
}
