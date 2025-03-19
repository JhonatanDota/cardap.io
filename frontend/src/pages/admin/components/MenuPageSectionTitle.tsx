interface MenuPageSectionTitleProps {
  title: string;
}

export default function MenuPageSectionTitle(props: MenuPageSectionTitleProps) {
  const { title } = props;

  return (
    <h2 className="uppercase text-2xl md:text-4xl font-semibold text-gray-800">
      {title}
    </h2>
  );
}
