import { Link } from "react-router-dom";

import AdminMenuItem from "./AdminMenuItem";
import HomeIcon from "../../../../../icons/HomeIcon";
import MetricsIcon from "../../../../../icons/MetricsIcon";
import CardapioIcon from "../../../../../icons/CardapioIcon";

interface AdminMenuItemsProps {
  isMenuExpanded: boolean;
}

export default function AdminMenuItems(props: AdminMenuItemsProps) {
  const { isMenuExpanded } = props;

  return (
    <div className="flex flex-col w-full mt-2 border-t-2 md:border-t-4 border-gray-700 overflow-hidden">
      <Link to={"/"}>
        <AdminMenuItem
          name="Home"
          icon={<HomeIcon />}
          isExpanded={isMenuExpanded}
        />
      </Link>
      <Link to={"/"}>
        <AdminMenuItem
          name="Métricas"
          icon={<MetricsIcon />}
          isExpanded={isMenuExpanded}
        />
      </Link>
      <Link to={"/"}>
        <AdminMenuItem
          name="Cardap.io"
          icon={<CardapioIcon />}
          isExpanded={isMenuExpanded}
        />
      </Link>
    </div>
  );
}
