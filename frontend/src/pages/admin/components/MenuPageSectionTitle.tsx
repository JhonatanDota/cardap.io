interface MenuPageSectionTitleProps {
  title: string;
}

export default function MenuPageSectionTitle(props: MenuPageSectionTitleProps) {
  const { title } = props;

  return (
    <h2 className="uppercase text-lg font-medium text-gray-800">{title}</h2>
  );
}
