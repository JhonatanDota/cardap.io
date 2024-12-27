import { MenuItemModel } from "../../../../models/menuModels";
import menuItemImage from "../../../../assets/images/fallback/menuItem.jpg";
import { currencyFormatter } from "../../../../functions/formatters";

interface MenuSectionItemProps {
  item: MenuItemModel;
}

export default function MenuSectionItem(props: MenuSectionItemProps) {
  const { item } = props;

  return (
    <div className="flex gap-2 md:gap-5 p-2 md:p-3 border-2 border-l-4 border-l-gray-600 rounded-md">
      <img
        className="self-center w-32 md:w-44 h-32 md:h-44 rounded-lg object-cover"
        src={item.image ?? menuItemImage}
        alt=""
      />

      <div className="flex flex-col justify-between">
        <p className="uppercase text-base md:text-xl font-semibold mb-2">
          {item.name}
        </p>

        <p className="text-sm md:text-lg">{item.description}</p>

        <p className="text-xs md:text-base font-normal leading-relaxed text-gray-800 m-2 md:m-4">
          {item.ingredients.join(" - ")}
        </p>

        <p className="text-base md:text-xl font-bold text-green-600">
          {currencyFormatter(item.price)}
        </p>
      </div>
    </div>
  );
}
