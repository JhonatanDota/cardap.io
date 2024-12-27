import { MenuItemModel } from "../../../../models/menuModels";
import menuItemImage from "../../../../assets/images/fallback/menuItem.jpg";
import { currencyFormatter } from "../../../../functions/formatters";

interface MenuSectionItemProps {
  item: MenuItemModel;
}

export default function MenuSectionItem(props: MenuSectionItemProps) {
  const { item } = props;

  return (
    <div className="flex gap-2 p-2 border-2 rounded-md">
      <img
        className="self-center w-32 h-32 rounded-lg object-cover"
        src={item.image ?? menuItemImage}
        alt=""
      />

      <div className="flex flex-col justify-between">
        <p className="uppercase text-base font-semibold">{item.name}</p>

        <p className="text-sm">{item.description}</p>

        <p className="text-xs font-normal text-gray-800 m-2">
          {item.ingredients.join(" - ")}
        </p>

        <p className="text-base font-bold text-green-600">
          {currencyFormatter(item.price)}
        </p>
      </div>
    </div>
  );
}
