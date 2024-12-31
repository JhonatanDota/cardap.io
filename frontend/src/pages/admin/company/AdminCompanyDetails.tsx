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
      <TextInput label="Nome" initialValue={company.name} />
      <ImageInput label="Logo" initialImageUrl={company.logo} />
      <ImageInput label="Banner" initialImageUrl={company.banner} />
    </MenuPageSectionContainer>
  );
}
