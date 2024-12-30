import { AddressModel } from "../../../models/addressModels";

interface AdminCompanyAddressProps {
  address: AddressModel;
}

export default function AdminCompanyAddress(props: AdminCompanyAddressProps) {
  const { address } = props;

  return <h1>COMPANY ADDRESS</h1>;
}
