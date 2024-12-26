interface CompanyNameProps {
  name: string;
}

export default function CompanyName(props: CompanyNameProps) {
  const { name } = props;

  return (
    <h1 className="uppercase font-bold text-center text-3xl mt-5 mb-2">
      {name}
    </h1>
  );
}
