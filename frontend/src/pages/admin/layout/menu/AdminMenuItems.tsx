import { NavLink } from "react-router-dom";
import AdminMenuItem from "./AdminMenuItem";
import HomeIcon from "../../../../icons/HomeIcon";
import CompanyIcon from "../../../../icons/CompanyIcon";
import MetricsIcon from "../../../../icons/MetricsIcon";
import CardapioIcon from "../../../../icons/CardapioIcon";

interface AdminMenuItemsProps {
  isMenuExpanded: boolean;
}

export default function AdminMenuItems(props: AdminMenuItemsProps) {
  const { isMenuExpanded } = props;

  return (
    <div className="flex flex-col w-full mt-2 border-t-2 md:border-t-4 border-gray-700 overflow-hidden">
      <NavLink to={"/admin"}>
        <AdminMenuItem
          name="Home"
          icon={<HomeIcon />}
          isExpanded={isMenuExpanded}
        />
      </NavLink>

      <NavLink to={"/admin/company"}>
        <AdminMenuItem
          name="Empresa"
          icon={<CompanyIcon />}
          isExpanded={isMenuExpanded}
        />
      </NavLink>

      <NavLink to={"/admin/menu"}>
        <AdminMenuItem
          name="Cardap.io"
          icon={<CardapioIcon />}
          isExpanded={isMenuExpanded}
        />
      </NavLink>

      <NavLink to={"/admin/metrics"}>
        <AdminMenuItem
          name="Métricas"
          icon={<MetricsIcon />}
          isExpanded={isMenuExpanded}
        />
      </NavLink>
    </div>
  );
}
