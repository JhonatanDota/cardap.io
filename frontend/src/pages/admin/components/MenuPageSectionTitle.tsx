interface MenuPageSectionTitleProps {
  title: string;
}

export default function MenuPageSectionTitle(props: MenuPageSectionTitleProps) {
  const { title } = props;
  
  return <h1>{title}</h1>;
}
