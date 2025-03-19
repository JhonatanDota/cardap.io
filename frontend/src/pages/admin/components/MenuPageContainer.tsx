interface MenuPageContainerProps {
  children: React.ReactNode;
}

export default function MenuPageContainer(props: MenuPageContainerProps) {
  const { children } = props;

  return (
    <section className="flex flex-col gap-2 md:gap-6 p-2 md:p-6">
      {children}
    </section>
  );
}
