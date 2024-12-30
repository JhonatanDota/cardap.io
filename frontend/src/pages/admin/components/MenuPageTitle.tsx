interface MenuPageTitleProps {
  title: string;
}

export default function MenuPageTitle(props: MenuPageTitleProps) {
  const { title } = props;

  return <h1 className="uppercase text-2xl font-bold">{title}</h1>;
}
