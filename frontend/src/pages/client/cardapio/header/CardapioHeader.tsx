import { CompanyModel } from "../../../../models/companyModels";
import { AddressModel } from "../../../../models/addressModels";

import Banner from "./Banner";
import Logo from "./Logo";
import CompanyName from "./CompanyName";
import OperatingStatus from "./OperatingStatus";
import Address from "./Address";

interface CardapioHeaderProps {
  company: CompanyModel;
  address: AddressModel;
}

export default function CardapioHeader(props: CardapioHeaderProps) {
  const { company, address } = props;

  return (
    <div className="flex flex-col">
      {/* <Banner imageUrl={company.banner} />
      <Logo imageUrl={company.logo} />
      <CompanyName name={company.name} />
      <OperatingStatus operatingStatus={company.operatingStatus}/> */}
      <Address address={address} />
    </div>
  );
}
