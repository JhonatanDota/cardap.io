import { AddressModel } from "../../../../models/addressModels";
import { addressFormatter } from "../../../../functions/formatters";
interface AddressProps {
  address: AddressModel;
}
export default function Address(props: AddressProps) {
  const { address } = props;

  return <p className="p-3 text-sm text-center">{addressFormatter(address)}</p>;
}
