interface CompanyNameProps {
  name: string;
}

export default function CompanyName(props: CompanyNameProps) {
  const { name } = props;

  return (
    <h1 className="uppercase font-bold text-center text-3xl md:text-4xl mt-5 md:mt-8 mb-1 md:mb-3">
      {name}
    </h1>
  );
}
