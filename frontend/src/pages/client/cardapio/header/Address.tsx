import { AddressModel } from "../../../../models/addressModels";
import { addressFormatter } from "../../../../functions/formatters";
interface AddressProps {
  address: AddressModel;
}
export default function Address(props: AddressProps) {
  const { address } = props;

  return (
    <p className="p-2 text-sm md:text-lg text-center">
      {addressFormatter(address)}
    </p>
  );
}
