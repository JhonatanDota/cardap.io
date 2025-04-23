interface MenuPageTitleProps {
  title: string;
}

export default function MenuPageTitle(props: MenuPageTitleProps) {
  const { title } = props;

  return (
    <h1 className="uppercase text-4xl md:text-5xl font-bold text-orange-600">
      {title}
    </h1>
  );
}
