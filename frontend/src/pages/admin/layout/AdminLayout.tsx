import { Outlet } from "react-router-dom";

import AdminMenu from "./menu/AdminMenu";

export default function AdminLayout() {
  return (
    <div className="flex">
      <AdminMenu />
      <main>
        <Outlet />
      </main>
    </div>
  );
}
