import { MenuSectionModel } from "../../../../models/menuModels";
import MenuSectionItem from "./MenuSectionItem";

interface MenuSectionProps {
  section: MenuSectionModel;
}

export default function MenuSection(props: MenuSectionProps) {
  const { section } = props;

  return (
    <div className="flex flex-col p-2 gap-2">
      <h4 className="uppercase text-orange-500 text-xl font-bold">
        {section.name}
      </h4>

      <div className="flex flex-col gap-3">
        {section.items.map((item) => (
          <MenuSectionItem key={item.id} item={item} />
        ))}
      </div>
    </div>
  );
}
