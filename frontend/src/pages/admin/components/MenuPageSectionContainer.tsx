interface MenuPageSectionContainerProps {
  children: React.ReactNode;
}

export default function MenuPageSectionContainer(
  props: MenuPageSectionContainerProps
) {
  const { children } = props;

  return <div className="flex flex-col gap-5 p-2">{children}</div>;
}
