import { CompanyModel } from "../../../models/companyModels";

import TextInput from "../components/inputs/TextInput";

interface AdminCompanyDetailsProps {
  company: CompanyModel;
}

export default function AdminCompanyDetails(props: AdminCompanyDetailsProps) {
  const { company } = props;

  return (
    <div>
      <TextInput label="Nome" initialValue={company.name} />
    </div>
  );
}
