interface MenuPageContainerProps {
  children: React.ReactNode;
}

export default function MenuPageContainer(props: MenuPageContainerProps) {
  const { children } = props;

  return <section className="p-4">{children}</section>;
}
