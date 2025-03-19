import { CompanyModel } from "../../../models/companyModels";

import MenuPageSectionContainer from "../components/MenuPageSectionContainer";

import TextInput from "../components/inputs/TextInput";
import ImageInput from "../components/inputs/ImageInput";

interface AdminCompanyDetailsProps {
  company: CompanyModel;
}

export default function AdminCompanyDetails(props: AdminCompanyDetailsProps) {
  const { company } = props;

  return (
    <MenuPageSectionContainer>
      <div className="grid grid-cols-1 md:grid-cols-2 gap-3">
        <TextInput label="Nome" initialValue={company.name} />
        <TextInput label="Nome" initialValue={company.name} />
      </div>

      <div className="grid grid-cols-1 md:grid-cols-2 gap-3">
        <ImageInput label="Logo" initialImageUrl={company.logo} />
        <ImageInput label="Banner" initialImageUrl={company.banner} />
      </div>
    </MenuPageSectionContainer>
  );
}
