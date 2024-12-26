interface AddressProps {
  address: string;
}
export default function Address(props: AddressProps) {
  const { address } = props;

  return <p className="p-3 text-sm text-center">{address}</p>;
}
