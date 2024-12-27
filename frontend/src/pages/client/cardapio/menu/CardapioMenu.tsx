import { MenuModel } from "../../../../models/menuModels";
import MenuSection from "./MenuSection";

interface CardapioMenuProps {
  menu: MenuModel;
}

export default function CardapioMenu(props: CardapioMenuProps) {
  const { menu } = props;

  return (
    <div className="flex flex-col gap-5 p-3">
      {menu.sections.map((section) => (
        <MenuSection key={section.id} section={section} />
      ))}
    </div>
  );
}
