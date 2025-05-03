interface MenuPageTitleProps {
  title: string;
}

export default function MenuPageTitle(props: MenuPageTitleProps) {
  const { title } = props;

  return (
    <h1 className="uppercase text-3xl md:text-4xl font-bold text-orange-600">
      {title}
    </h1>
  );
}
